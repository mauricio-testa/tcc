<template>
    <div>
        <v-navigation-drawer v-model="drawer" :clipped="$vuetify.breakpoint.lgAndUp" color="grey lighten-4" app>

            <v-list-item two-line class="py-2">
                <v-list-item-content>
                    <v-list-item-title>{{unidade}}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>
            
            <v-list dense>
                <template v-for="item in menus">

                    <!-- heading -->
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

                    <!-- items -->
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
                    <v-list-item v-else
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
            </v-list>
        </v-navigation-drawer>

        <!-- heading -->
        <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app color="primary" dark dense>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
                <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
                    <span class="hidden-sm-and-down">SIMTRAP </span>
                </v-toolbar-title>

            <v-spacer/>

            <div class="text-center">
                <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    :nudge-width="240"
                    offset-y
                >
                    <template v-slot:activator="{ on }">
                        <v-btn icon large v-on="on">
                                <v-avatar size="32px" item color="red">
                                    <span class="white--text">{{ avatar }}</span>
                                </v-avatar>
                            </v-btn>
                    </template>

                    <v-card>

                        <v-list>
                            <v-list-item>
                                <v-list-item-avatar color="red">
                                    <span class="white--text">{{ avatar }}</span>
                                </v-list-item-avatar>
                                <v-list-item-content>
                                    <v-list-item-title>{{user.nome}}</v-list-item-title>
                                    <v-list-item-subtitle>Logado</v-list-item-subtitle>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-btn color="primary" text>alterar senha</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" text @click="logout" >
                                <v-icon class="ml-2">mdi-logout</v-icon>
                            </v-btn>
                        </v-card-actions>

                    </v-card>
                </v-menu>
            </div>
        </v-app-bar>
    </div>
</template>

<script>
    export default {
        props: {
            source: String,
            menus: Array,
            user: Object,
            unidade: String,
        },
        data: () => ({
            dialog: false,
            drawer: null,
            menu: false,
        }),

        methods: {
            open: function(url){
                window.location = url
            },
            logout: function() {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
        },

        computed: {

            avatar: function () {
                let ar = this.user.nome.split(' ');
                let avatar = ar[0].substr(0,1)
                if (ar.length > 1) {
                    avatar += ar[ar.length-1].substr(0,1)
                }
                return avatar.toUpperCase();
            }
        }
    }
</script>