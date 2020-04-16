<template>
  <div>
    <v-row>
      <v-col v-for="(stat, key) in stats" :key="key" cols="12" sm="3">
        <v-card :class="stat.color" tile dark>
          <v-list-item class="pa-0">
            <v-list-item-content class="px-2">
              <v-list-item-title class="display-2 text-center"> {{ stat.value }} </v-list-item-title>
              <v-list-item-subtitle class="text-center pb-2">{{ stat.title }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>

  export default {
    data: () => ({
      stats: [
        {icon: 'mdi-account', title: 'Viagens Realizadas', 'value' : 100, color: 'blue darken-2'},
        {icon: 'mdi-account', title: 'Pacientes Transportados', 'value' : 100, color: 'indigo darken-2'},
        {icon: 'mdi-account', title: 'Viagens Hoje', 'value' : 100, color: 'teal darken-2'},
        {icon: 'mdi-account', title: 'Viagens a Realizar', 'value' : 100, color: 'red darken-2'}
      ]
    }),
  }
</script>