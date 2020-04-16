<template>
    <div>
        <v-row>
        <v-col cols="4" v-for="i in 3" :key="i">
            <v-card>
            <v-list class="blue" dark>
                <v-subheader>TOP VIAGENS POR VEÍCULO</v-subheader>
            <v-list-item>
                <v-list-item-icon>
                <v-icon size="42">mdi-trophy</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                <v-list-item-title>#1 Marciel Testa</v-list-item-title>
                <v-list-item-subtitle>13 viagens</v-list-item-subtitle>
                </v-list-item-content>

            </v-list-item>
            
            </v-list>
            <v-list dense >
            <v-list-item v-for="z in 4" :key="z">
                <v-list-item-icon>
                    <span class="subtitle-2 text--secondary"># {{z+1}}</span>
                </v-list-item-icon>

                <v-list-item-content>
                <v-list-item-title>Marciel Testa</v-list-item-title>
                <v-list-item-subtitle>13 viagens</v-list-item-subtitle>
                </v-list-item-content>

            </v-list-item>
            </v-list>
            </v-card>
        </v-col>
        </v-row>
    </div>
</template>
