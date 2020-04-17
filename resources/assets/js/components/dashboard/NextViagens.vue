<template>
    <v-card>
        <v-card-text>
        <v-simple-table :fixed-header="true" :height="190">
            <template v-slot:default>
            <thead>
                <tr>
                <th>Data</th>
                <th>Destino</th>
                <th>Veículo</th>
                <th>Passag.</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="viagem in viagens" :key="viagem.id">
                <td>{{viagem.data_formated}}</td>
                <td>{{viagem.municipio_nome}}</td>
                <td>{{viagem.veiculo}}</td>
                <td>{{viagem.passageiros}}</td>
                <td><v-icon @click="exportList(viagem.id)">mdi-printer-pos</v-icon></td>
                </tr>
            </tbody>
            </template>
        </v-simple-table>
    </v-card-text>
</v-card>
    
</template>

<script>
export default {
    data: () => ({
        viagens: [],
        popupParams: null,
    }),
    mounted () {
        // define parametros de abertura do popup de exportação da lista
        let windowWidth = window.innerWidth - 200;
        let windowHeight = window.innerHeight - 100;
        let left = (window.innerWidth / 2) - (windowWidth / 2)
        this.popupParams = `width=${windowWidth}, height=${windowHeight}, top=50, left=${left}`;

        this.viagens = this.$parent.data.proximas_viagens;
    },
    methods: {
        exportList: function(id) {
            let popup = window.open('./relatorios/lista/'+id, 'Exportação de lista', this.popupParams);
            if (!popup || popup.closed || typeof popup.closed=='undefined') { 
                window.open('./relatorios/lista/'+id, 'blank')
            }
        }
    }
  }
</script>