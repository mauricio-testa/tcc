<template>
<div>

    <v-dialog v-model="dialogList" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <v-row>
                <v-col cols="12" md="8">
                    Lista de Passageiros
                    <v-btn class="ml-4" fab dark small color="primary" @click="addNewPassageiro">
                    <v-icon dark>mdi-plus</v-icon>
                    </v-btn>
                </v-col>
                </v-row>                        
            </v-card-title>
            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="lista"
                    hide-default-footer
                    disable-sort
                    no-data-text="Nenhum paciente adicionado na lista ainda."
                    loading-text="Buscando dados..."
                >
                    <!-- table actions -->
                    <template v-slot:item.action="{ item }">
                        <v-icon class="mr-2">mdi-pencil</v-icon>
                        <v-icon @click="deletePassageiro(item, false)">mdi-delete</v-icon>
                    </template>
                </v-data-table>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">Sair</v-btn>
            </v-card-actions>
        </v-card>
     </v-dialog>

    <!-- dialog edit / new paciente -->
    <v-dialog v-model="dialogEditPassageiro" max-width="500px">
        <v-form v-model="formPassageiroValid" ref="formEditPassageiro">
            <v-card>
                <v-card-title>
                    <span class="headline">Paciente</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field label="Nome"></v-text-field>
                        <v-text-field label="Local da Consulta"></v-text-field>
                        <v-text-field label="Horário da consulta"></v-text-field>
                        <v-text-field label="Médico"></v-text-field>
                        <v-switch
                            v-model="precisaAcompanhante"
                            label="Precisa acompanhante?"
                        ></v-switch>
                        <v-text-field v-if="precisaAcompanhante" label="Nome do acompanhante"></v-text-field>
                        <v-text-field v-if="precisaAcompanhante" label="RG do acompanhante"></v-text-field>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="dialogEditPassageiro = false">Cancelar</v-btn>
                    <v-btn color="blue darken-1" text>Salvar</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>

    <!-- dialog delete passageiro -->
    <v-dialog v-model="dialogDeletePassageiro" max-width="290">
        <v-card>
            <v-card-title class="headline">Confirmar exclusão?</v-card-title>
            <v-card-text>Tem certeza que deseja deletar o passageiro {{selectedPassageiro.paciente_nome}} dessa lista?</v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialogDeletePassageiro = false">Cancelar</v-btn>
                <v-btn color="red darken-1" text @click="deletePassageiro(selectedPassageiroIndex, true)">Excluir</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</div>
</template>
<script>

    export default {
    
        props: {
            dialogList: {
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

            dialogEditPassageiro: false,
            dialogDeletePassageiro: false,

            selectedPassageiro: [],
            selectedPassageiroIndex: null,

            precisaAcompanhante: false,

            formPassageiroValid: false,

            headers: [
                { text: 'Paciente', value: 'paciente_nome'},
                { text: 'Local', value: 'consulta_local'},
                { text: 'Hora', value: 'consulta_hora'},
                { text: 'Ações', value: 'action'},
            ],
            lista: []

        }),

        mounted () {},

        watch: {

            dialogList: function(val) {
                if (val) this.initialize();
            },
        },

        methods: { 

            close () {
                this.$emit('update:dialogList', false)
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
                this.getListaPassageiros();

            },

            resetPassageiroEditValidation: function () {
                if(typeof this.$refs.formEditPassageiro != "undefined") this.$refs.formEditPassageiro.resetValidation();
            },

            // lista

            addNewPassageiro: function () {
                this.precisaAcompanhante = false;
                this.dialogEditPassageiro = true;
            },

            getListaPassageiros () {
                let vm = this;
                axios
                    .get('http://localhost:8000/api/lista')
                    .then(function(response) {
                        vm.lista = response.data
                        console.log(vm.lista)
                    })
                    .catch(function(error) {
                        console.error(error)
                    })
            },

            deletePassageiro: function (item, confirm) {
                
                if (!confirm) {
                    this.selectedPassageiro = item;
                    this.selectedPassageiroIndex = this.lista.indexOf(item);
                    this.dialogDeletePassageiro = true
                    return;
                }
                
                let vm = this;

                vm.lista.splice(vm.selectedPassageiroIndex, 1);
                vm.dialogDeletePassageiro = false;;
                /*
                axios
                    .delete('http://localhost:8000/api/lista/'+vm.selectedPassageiro.id_paciente)
                    .then(function(response){
                        if(response.data.error) {
                            vm.$toast.error('Erro ao deletar: '+response.data.error)
                        }
                        else {
                            vm.$toast.success('Passageiro deletado com sucesso!')
                            vm.lista.splice(vm.selectedPassageiroIndex, 1)
                        }
                    })
                    
                .finally(function() {
                    vm.dialogDeletePassageiro = false;
                });
                */
            },
        }
    }
</script>