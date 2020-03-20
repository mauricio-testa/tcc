<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            :clipped="$vuetify.breakpoint.lgAndUp"
            color="primary"
            app
            dark
        >
            <!-- src="https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg" -->
            <v-list-item two-line>
                <v-list-item-avatar>
                    <img src="https://randomuser.me/api/portraits/women/81.jpg">
                </v-list-item-avatar>

                <v-list-item-content>
                    <v-list-item-title>{{ user.nome }}</v-list-item-title>
                    <v-list-item-subtitle>Logado</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>
            
            <v-list dense>
                <template v-for="item in menus">
                    
                    <v-row
                        v-if="item.heading"
                        :key="item.heading"
                        align="center"
                        >
                        <v-col cols="6">
                            <v-subheader v-if="item.heading">
                            {{ item.heading }}
                            </v-subheader>
                        </v-col>
                    </v-row>

                    <v-list-group
                        v-else-if="item.children"
                        :key="item.text"
                        v-model="item.model"
                        :prepend-icon="item.model ? item.icon : item['icon-alt']"
                        append-icon=""
                        >
                        <template v-slot:activator>
                            <v-list-item-content>
                            <v-list-item-title>
                                {{ item.text }}
                            </v-list-item-title>
                            </v-list-item-content>
                        </template>
                        <v-list-item
                            v-for="(child, i) in item.children"
                            :key="i"
                            link
                        >
                            <v-list-item-action v-if="child.icon">
                                <v-icon>{{ child.icon }}</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>{{ child.text }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>

                    <v-list-item
                        v-else
                        :key="item.text"
                        link
                        @click="open(item.url)"
                    >
                        <v-list-item-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                            {{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>          
                </template>

                <v-list-item @click="logout">
                    <v-list-item-action>
                        <v-icon>mdi-logout</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>


        <v-app-bar
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            app
            color="blue darken-3"
            dark
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
                <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
                <span class="hidden-sm-and-down">SIMTRAP</span>
                </v-toolbar-title>
            <v-text-field
                flat
                solo-inverted
                hide-details
                prepend-inner-icon="mdi-magnify"
                label="Search"
                class="hidden-sm-and-down"
            />
            <v-spacer />
            <v-btn icon>
                <v-icon>mdi-bell</v-icon>
            </v-btn>
            <v-btn icon large>
                <v-avatar size="32px" item>
                    <v-img
                        src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
                        alt="Vuetify"
                    />
                </v-avatar>
            </v-btn>
        </v-app-bar>

    </div>
</template>

<script>
    export default {
        props: {
            source: String,
            menus: Array,
            user: Object
        },
        data: () => ({
            dialog: false,
            drawer: null,
        }),

        methods: {
            open: function(url){
                window.location = url
            },
            logout: function() {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>