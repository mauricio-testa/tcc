<template>
<div>
     <v-dialog v-model="dialogEdit" max-width="500px" @click:outside="close">
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
                                :loading="isLoading.lookupMunicipios"
                                item-text="nome"
                                item-value="codigo"
                                label="Qual o destino da viagem?"
                                :rules="[v => !!v || 'Destino é obrigatório']"
                            ></v-autocomplete>
                            <v-autocomplete
                                v-model="viagem.id_veiculo"
                                :items="lookupVeiculos"
                                :loading="isLoading.lookupVeiculos"
                                item-text="descricao"
                                item-value="id"
                                label="Qual veículo será utilizado?"
                                :rules="[v => !!v || 'Veículo é obrigatório']"
                            ></v-autocomplete>
                            <v-autocomplete
                                v-model="viagem.id_motorista"
                                :items="lookupMotoristas"
                                :loading="isLoading.lookupMotoristas"
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

    <lookup ref="lookupComponent" v-on:updateLookup="updateLookup"></lookup>
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

            isLoading: {
                lookupVeiculos: false,
                lookupMunicipios: false,
                lookupMotoristas: false
            },

            lookupVeiculos: [],
            lookupMunicipios: [],
            lookupMotoristas: [],
            
            formViagemValid: false,

        }),

        mounted () {},

        watch: {

            dialogEdit: function(val) {
                if (val) this.initialize();
            },

        },

        methods: { 

            /*
            * Salvar item editado ou novo
            * Se tiver index é edição, senão é novo registro
            */

            save: function () {

                if (!this.$refs.formEditViagem.validate()) return;
                let vm = this;
                
                if (this.viagem.id != null) {
                    axios
                    .put(this.$parent.api+'/'+this.viagem.id, vm.viagem)
                    .then(function(response){
                        if(response.data.error) {
                            vm.$toast.error(response.data.error)
                        }
                        else {
                            vm.close()
                            vm.$emit('callback')
                            vm.$toast.success('Viagem salva com sucesso!')
                        }
                    })

                } else {
                    axios
                    .post(this.$parent.api, {
                        'cod_destino'   : vm.viagem.cod_destino,
                        'data_viagem'   : vm.viagem.data_viagem,
                        'hora_saida'    : vm.viagem.hora_saida,
                        'id_motorista'  : vm.viagem.id_motorista,
                        'id_veiculo'    : vm.viagem.id_veiculo,
                        'observacao'    : vm.viagem.observacao
                    })
                    .then(function(response){
                        if(response.data.error) {
                            vm.$toast.error('Erro ao cadastrar: '+response.data.error)
                        }
                        else {
                            vm.close()
                            vm.$emit('callback', response.data.id)
                            vm.$toast.success('Viagem cadastrada com sucesso!')
                        }
                    })
                }
            },

            close () {
                this.$emit('update:dialogEdit', false)
            },
            
            // callback da busca de lookup
            updateLookup (datasetName, dataArray) {
                if (datasetName == 'VEICULO') {
                    this.lookupVeiculos             = dataArray
                    this.isLoading.lookupVeiculos   = false
                }
                if (datasetName == 'MOTORISTA') {
                    this.lookupMotoristas           = dataArray
                    this.isLoading.lookupMotoristas = false
                }
                if (datasetName == 'MUNICIPIO') {
                    this.lookupMunicipios           = dataArray
                    this.isLoading.lookupMunicipios = false
                }
            },

            initialize: function () {

                if (this.lookupVeiculos.length == 0) {
                    this.isLoading.lookupVeiculos = true
                    this.$refs.lookupComponent.getLookup('VEICULO');
                }
                if (this.lookupMunicipios.length == 0) {
                    this.isLoading.lookupMunicipios = true
                    this.$refs.lookupComponent.getLookup('MOTORISTA');
                }
                if (this.lookupMunicipios.length == 0) {
                    this.isLoading.lookupMunicipios = true
                    this.$refs.lookupComponent.getLookup('MUNICIPIO');
                }

                this.lookupMotoristas.id        = this.viagem.id_motorista
                this.lookupVeiculos.id          = this.viagem.id_veiculo
                this.lookupMunicipios.codigo    = this.viagem.cod_destino
                
                this.resetViagemEditValidation();

            },

            resetViagemEditValidation: function () {
                if (typeof this.$refs.formEditViagem != "undefined") this.$refs.formEditViagem.resetValidation();
            },
        }
    }
</script>