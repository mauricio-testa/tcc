<template>
<div>
     <v-dialog v-model="dialogEdit" persistent max-width="500px">
            <v-form v-model="formViagemValid" ref="formEditViagem">
                <v-card>
                    <v-card-title>
                        <span class="headline">Viagem</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>

                            <v-autocomplete
                                v-model="viagem.cod_destino"
                                :items="lookupMunicipios"
                                :loading="isLoading"
                                :search-input.sync="searchMunicipios"
                                item-text="nome"
                                item-value="codigo"
                                label="Qual o destino da viagem?"
                                :rules="[v => !!v || 'Destino é obrigatório']"
                            ></v-autocomplete>
                            <v-autocomplete
                                v-model="viagem.id_veiculo"
                                :items="lookupVeiculos"
                                :loading="isLoading"
                                :search-input.sync="searchVeiculos"
                                item-text="descricao"
                                item-value="id"
                                label="Qual veículo será utilizado?"
                                :rules="[v => !!v || 'Veículo é obrigatório']"
                            ></v-autocomplete>
                            <v-autocomplete
                                v-model="viagem.id_motorista"
                                :items="lookupMotoristas"
                                :loading="isLoading"
                                :search-input.sync="searchMotoristas"
                                item-text="nome"
                                item-value="id"
                                label="Quem será o motorista?"
                            ></v-autocomplete>
                            <v-row>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field 
                                        type="date"
                                        label="Qual a data da viagem?" 
                                        v-model="viagem.data_viagem"
                                        :rules="[v => !!v || 'Data é obrigatório']"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field 
                                        label="Qual o horário de saída?" 
                                        v-model="viagem.hora_saida"
                                        type="time"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-textarea
                                label="Alguma observação?"
                                hint="Hint text"
                                v-model="viagem.observacao"
                                rows="3"
                            ></v-textarea>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="red darken-1" text @click="close">Cancelar</v-btn>
                        <v-btn color="blue darken-1" text @click="save">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>


    </v-dialog>

</div>
</template>

<script>

    export default {
    
        props: {
            dialogEdit: {
                type: Boolean,
                required: true
            },
            viagem: {
                type: Object,
                required: true
            }
        },

        data: () => ({

            isLoading: false,

            lookupVeiculos: [{id: null, descricao: null}],
            lookupMunicipios: [{codigo: null, nome: null}],
            lookupMotoristas: [{id: null, nome: null}],

            searchLista: null,
            searchVeiculos: null,
            searchMunicipios: null,
            searchMotoristas: null,
            
            formViagemValid: false,

        }),

        mounted () {},

        watch: {

            dialogEdit: function(val) {
                if (val) this.initialize();
            },

            searchVeiculos (val) {
                if (this.lookupVeiculos.length > 1) return
                this.getLookup('VEICULO');    
            },
            searchMotoristas(val) {
                if (this.lookupMotoristas.length > 1) return
                this.getLookup('MOTORISTA')
            },
            searchMunicipios(val) {
                if (this.lookupMunicipios.length > 1) return
                this.getLookup('MUNICIPIO')
            }
        },

        methods: { 

            save: function () {

            },

            close () {
                this.$emit('update:dialogEdit', false)
            },
            
            getLookup (dataset) {
                
                let api = null;
                let vm  = this;

                if (dataset == 'VEICULO')   api = 'http://localhost:8000/api/veiculos';
                if (dataset == 'MOTORISTA') api = 'http://localhost:8000/api/motoristas';
                if (dataset == 'MUNICIPIO') api = 'http://localhost:8000/api/municipios';

                axios
                    .get(api)
                    .then(function(response) {
                        if (dataset == 'VEICULO')   vm.lookupVeiculos   = response.data.data
                        if (dataset == 'MOTORISTA') vm.lookupMotoristas = response.data.data
                        if (dataset == 'MUNICIPIO') vm.lookupMunicipios = response.data
                    })
                    .catch(function(error) {
                        console.error(error)
                    })
                    .finally(() => (this.isLoading = false))
            },

            initialize: function () {
                // fill veiculo field
                this.lookupVeiculos.id = this.viagem.id_veiculo
                this.lookupVeiculos.descricao = this.viagem.veiculo
                this.searchVeiculos = '' 

                // fill veiculo field
                this.lookupMunicipios.codigo = this.viagem.cod_destino
                this.lookupMunicipios.nome = this.viagem.municipio_nome
                this.searchMunicipios = ''

                // fill veiculo field
                this.lookupMotoristas.id = this.viagem.id_motorista
                this.lookupMotoristas.nome = this.viagem.motorista_nome
                this.searchMotoristas = '' // handle watcher

                this.resetViagemEditValidation();

            },

            resetViagemEditValidation: function () {
                if(typeof this.$refs.formEditViagem != "undefined") this.$refs.formEditViagem.resetValidation();
            },
        }
    }
</script>