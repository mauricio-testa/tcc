<template>
    <div>
        <v-card>
        
            <v-card-title>Relatório de Viagens por Paciente</v-card-title>
            <v-card-text>
                <v-alert outlined color="blue">
                    Dica! Você também pode gerar este relatório pela lista de pacientes
                </v-alert>
                <div class="d-flex align-center">
                    <v-autocomplete
                        v-model="id_paciente"
                        :items="lookupPacientes"
                        :loading="loading.lookup"
                        :search-input.sync="searchPacientes"
                        item-text="nome"
                        item-value="id"
                        label="Selecione um paciente..."
                        :rules="[v => !!v || 'Obrigatório!']"
                        no-data-text="Digite algo para pesquisar..."
                        @keyup="search"
                    ></v-autocomplete>
                    <v-btn class="ml-5" large dark
                        @click="gerarRelatorioPaciente"
                    >Gerar</v-btn>
                </div>
            </v-card-text>
        </v-card>

        <br><br><br><br><br>

        Relatório de Viagens [A DESENVOLVER]
        <br> Filtrar por: data inicial e final, motorista, destino, order by
        <br> Exibir: id viagem, data, hora saída, veiculo, destino, motorista, número de passageiros (pacientes/acompanhantes)

        <br><br><br><br><br>

        Lista de Viagem
        <v-alert type="info">
            Para gerar este relatório, utilize o menu "Viagens" e clique no ícone da impressora da viagem que deseja exportar. 
            Você também pode exportar esse relatório diretamente pela própria tela de adição de passageiros
        </v-alert>


        <lookup  ref="lookupComponent" v-on:updateLookup="updateLookup"></lookup>
    </div>
</template>
<script>
export default {
    data: () => ({
        lookupPacientes: [],
        loading: {
            lookup: false,
        },
        searchPacientes: null,
        timeoutId: null,
        id_paciente: null,
    }),

    methods: {

        gerarRelatorioPaciente () {
            if (this.id_paciente < 1) {
                this.$toast.warning('Por favor, selecione o paciente para o qual deseja gerar o relatório');
                return;
            }
            this.$openPopup('./relatorios/paciente/'+this.id_paciente, 'paciente')
        },

        /* LOOKUP E SEARCH */
        search () {
            if (this.searchPacientes == null || this.searchPacientes == '') return
            this._debounce();
        },
        _debounce(){
            this.loading.lookup = true;
            if (this.timeoutId !== null) {
                clearTimeout(this.timeoutId);
            }
            this.timeoutId = setTimeout( _ => {
                this.getPacientesLookup();
            }, this.$debounceTime);
        },
        getPacientesLookup: function () {
            this.$refs.lookupComponent.getLookup('PACIENTE', this.searchPacientes);
        },
        updateLookup (datasetName, dataArray) {
            this.lookupPacientes = dataArray;
            this.loading.lookup = false;
        },
    }
}
</script>