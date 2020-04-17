<template>
  <div>
    <v-sheet class="headline my-2">Dashboard</v-sheet>

    <!-- estatisticas -->
    <dashboard-stats></dashboard-stats>

    <v-row>
      <!--gratico pacientes transportados -->
      <v-col sm="12" md="6">
        <v-sheet class="subtitle-1 my-4">Transporte de Pacientes por Mês nos Últimos 6 Mêses</v-sheet>
        <v-card>
          <v-card-text>
            <dashboard-graph-pacientes :data="data.total_passageiros_mes" style="height: 335px"></dashboard-graph-pacientes>
          </v-card-text>
        </v-card>
        <v-sheet class="subtitle-1 my-4">Índice de Absenteísmo</v-sheet>
        <v-card>
          <v-card-text>
            Lorem Ipsum
          </v-card-text>
        </v-card>
      </v-col>

      <v-col sm="12" md="6">
        <!-- listagem proximas viagens -->
        <v-sheet class="subtitle-1 my-4">Proximas Viagens</v-sheet>
        <dashboard-next-viagens></dashboard-next-viagens>

        <!-- grafico viagens por mes -->
        <v-sheet class="subtitle-1 my-4">Viagens por Mês Neste Ano</v-sheet>
        <v-card>
          <v-card-text>
            <dashboard-graph-viagens :data="data.total_viagens_mes" style="height: 168px"></dashboard-graph-viagens>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- top 5 veiculos, motoristas, destinos -->
    <dashboard-top5></dashboard-top5>
  </div>
</template>

<script>
export default {
  props: ["data"]
};
</script>