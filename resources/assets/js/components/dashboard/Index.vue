<template>
  <div>
    <v-sheet class="headline my-2">Dashboard</v-sheet>

    <!-- estatisticas -->
    <dashboard-stats></dashboard-stats>

    <v-row>
      <!--gratico pacientes transportados -->
      <v-col sm="12" md="6">
        <v-sheet class="subtitle-1 my-4">Transporte de Pacientes por Mês nos Últimos 6 Mêses</v-sheet>
          <dashboard-graph-pacientes></dashboard-graph-pacientes>
      </v-col>

      <v-col sm="12" md="6">

        <!-- listagem proximas viagens -->
        <v-sheet class="subtitle-1 my-4">Proximas Viagens</v-sheet>
        <dashboard-next-viagens></dashboard-next-viagens>

        <!-- grafico viagens por mes -->
        <v-sheet class="subtitle-1 my-4">Viagens por Mês Neste Ano</v-sheet>
        <dashboard-graph-viagens></dashboard-graph-viagens>
      </v-col>
    </v-row>

    <!-- top 5 veiculos, motoristas, destinos -->
    <dashboard-top5></dashboard-top5>

  </div>
</template>

<script>
export default {
  props: ['data'],
}
</script>