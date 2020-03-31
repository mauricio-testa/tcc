<template>
<div>

    <!-- dialog list -->
    <v-dialog v-model="dialogList" max-width="700px" @click:outside="close">
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
                    :loading="loading"
                >
                    <template v-slot:item.acompanhante_nome="{ item }">
                        <v-icon color="green" text  v-if="item.acompanhante_nome != null">mdi-check</v-icon>
                    </template>
                    <!-- table actions -->
                    <template v-slot:item.action="{ item }">
                        <v-icon @click="editItem(item)" class="mr-2">mdi-pencil</v-icon>
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
    <v-dialog v-model="dialogEditPassageiro" max-width="500px" @click:outside="closeDialogPassageiro">
        <v-form v-model="formPassageiroValid" ref="formEditPassageiro">
            <v-card>
                <v-card-title>
                    <span class="headline">Paciente</span>
                </v-card-title>
                <v-card-text>
                    <v-container>

                        <v-autocomplete
                            v-model="selectedPassageiro.id_paciente"
                            :items="lookupPacientes"
                            :loading="loadingPacientes"
                            :search-input.sync="searchPacientes"
                            item-text="nome"
                            item-value="id"
                            label="Selecione um paciente..."
                            :disabled="selectedPassageiroIndex > -1"
                            :rules="[v => !!v || 'Obrigatório!']"
                            no-data-text="Digite algo para pesquisar..."
                            @keypress="search"
                        ></v-autocomplete>

                        <v-text-field 
                            label="Local da Consulta" 
                            v-model="selectedPassageiro.consulta_local"
                            :rules="[v => !!v || 'Local é obrigatório']"
                        ></v-text-field>
                        <v-text-field 
                            type="time"
                            label="Horário da consulta" 
                            v-model="selectedPassageiro.consulta_hora"
                            :rules="[v => !!v || 'Horário é obrigatório']"
                        ></v-text-field>
                        <v-text-field label="Médico" v-model="selectedPassageiro.consulta_medico"></v-text-field>
                        <v-switch
                            v-model="precisaAcompanhante"
                            label="Precisa acompanhante?"
                        ></v-switch>
                        <v-text-field v-if="precisaAcompanhante" v-model="selectedPassageiro.acompanhante_nome" label="Nome do acompanhante"></v-text-field>
                        <v-text-field v-if="precisaAcompanhante" v-model="selectedPassageiro.acompanhante_rg" label="RG do acompanhante"></v-text-field>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="closeDialogPassageiro">Cancelar</v-btn>
                    <v-btn color="blue darken-1" text @click="save">Salvar</v-btn>
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

            // main data
            lista: [],
            lookupPacientes: [],

            // table column names
            headers: [
                { text: 'Paciente', value: 'paciente_nome'},
                { text: 'Local', value: 'consulta_local'},
                { text: 'Hora', value: 'consulta_hora'},
                { text: 'Acompanhante', value: 'acompanhante_nome'},
                { text: 'Ações', value: 'action'},
            ],

            // state of elements
            loading: false,
            loadingPacientes: false,
            dialogEditPassageiro: false,
            dialogDeletePassageiro: false,
            precisaAcompanhante: false,
            formPassageiroValid: false,
            timeoutId: null,

            // CRUD variables
            searchPacientes: null,
            selectedPassageiroIndex: null,
            selectedPassageiro: {
                id_paciente: null,
                id_viagem: null,
                acompanhante_rg: null,
                acompanhante_nome: null,
                consulta_local: null,
                consulta_hora: null,
                consulta_medico: null,
            },
            defaultPassageiro: {
                id_paciente: null,
                id_viagem: null,
                acompanhante_rg: null,
                acompanhante_nome: null,
                consulta_local: null,
                consulta_hora: null,
                consulta_medico: null,
            },
        }),      

        methods: { 
            
            search () {
                // pra não pesquisar se está disable
                if (this.selectedPassageiroIndex > -1) return
                if (this.searchPacientes == null) return
                this._debounce();
            },

            getListaPassageiros () {

                this.loading = true;
                let vm = this;

                axios
                .get('http://localhost:8000/api/lista?viagem='+vm.viagem.id)
                .then(function(response) {
                    vm.lista = response.data
                })
                .catch((error) => console.log(error))
                .finally(() => vm.loading = false)
            },

            /*
            * Exclui um registro
            * @param item Obj
            * @param confirm bool
            * Ao clicar nas ações da tabela o parametro confirm vem false e abre o dialog de confirmação
            * Para ficar true é necessário confirmar no dialog que abre posteriormente
            */

            deletePassageiro: function (item, confirm) {
                
                if (!confirm) {
                    this.selectedPassageiro = item;
                    this.selectedPassageiroIndex = this.lista.indexOf(item);
                    this.dialogDeletePassageiro = true
                    return;
                }
                
                let vm = this;
                
                axios
                    .delete('http://localhost:8000/api/lista/'+vm.selectedPassageiro.id_paciente, {
                        data: {"viagem": vm.selectedPassageiro.id_viagem}, 
                        headers: {"Authorization": "***"}}
                    )
                    .then(function(response){
                        if(response.data.error) {
                            vm.$toast.error('Erro ao deletar: '+response.data.error)
                        }
                        else {
                            vm.$toast.success('Passageiro deletado com sucesso!')
                            vm.lista.splice(vm.selectedPassageiroIndex, 1);
                        }
                    })
                    .finally(() => vm.dialogDeletePassageiro = false);
            },

            /*
            * Salvar item editado ou novo
            * Se tiver index é edição, senão é novo registro
            */

            save: function () {

                if (!this.$refs.formEditPassageiro.validate()) return;
                let vm = this;

                if (vm.selectedPassageiroIndex > -1) {
                    axios
                    .put('http://localhost:8000/api/lista/'+this.viagem.id, vm.selectedPassageiro)
                    .then(function(response){
                        if(response.data.error) {
                            vm.$toast.error('Erro ao editar: '+response.data.error)
                        }
                        else {
                            Object.assign(vm.lista[vm.selectedPassageiroIndex], vm.selectedPassageiro)
                            vm.dialogEditPassageiro = false;
                            vm.$toast.success('Passageiro salvo com sucesso!')
                        }
                    })

                } else {
                    axios
                    .post('http://localhost:8000/api/lista/', {
                        'id_paciente'       : vm.selectedPassageiro.id_paciente,
                        'id_viagem'         : vm.viagem.id,
                        'acompanhante_rg'   : vm.selectedPassageiro.acompanhante_rg,
                        'acompanhante_nome' : vm.selectedPassageiro.acompanhante_nome,
                        'consulta_local'    : vm.selectedPassageiro.consulta_local,
                        'consulta_hora'     : vm.selectedPassageiro.consulta_hora,
                        'consulta_medico'   : vm.selectedPassageiro.consulta_medico,
                    })
                    .then(function(response){
                        if(response.data.error) {
                            vm.$toast.error('Erro ao cadastrar: '+response.data.error)
                        }
                        else {
                            vm.dialogEditPassageiro = false;
                            vm.getListaPassageiros();
                            vm.$toast.success('Passageiro cadastrado com sucesso!')
                        }
                    })
                }
            },

            // vue não permite editar diretamente uma prop. por isso, usa-se emit aqui e prop.sync no componente pai
            close () {
                this.$emit('update:dialogList', false)
            },

            closeDialogPassageiro () {
                // fica com length == 1 quando edita 
                if (this.lookupPacientes.length <= 2) this.lookupPacientes = []
                this.dialogEditPassageiro = false;
            },

            // executado quando abre o modal
            initialize: function () {
                this.lista = [];
                this.defaultPassageiro.id_viagem = this.viagem.id
                this.getListaPassageiros();
            },

            // $ref do formulario nao está disponivel na criação do componente
            resetPassageiroEditValidation: function () {
                if(typeof this.$refs.formEditPassageiro != "undefined") this.$refs.formEditPassageiro.resetValidation();
            },

            // Abre modal e assinala index nulo e valores padrão para inserir novo registro
            addNewPassageiro: function () {
                this.selectedPassageiroIndex = -1;
                this.precisaAcompanhante = false;
                this.selectedPassageiro = Object.assign({}, this.defaultPassageiro);
                this.resetPassageiroEditValidation();
                this.dialogEditPassageiro = true;
            },

            // Abre o modal de edição a partir da coluna "Ações" da tabela
            editItem: function (item) {
                this.selectedPassageiroIndex = this.lista.indexOf(item);
                this.selectedPassageiro = Object.assign({}, item);
                this.precisaAcompanhante = item.acompanhante_nome != null && item.acompanhante_nome != '';
                this.resetPassageiroEditValidation();
                this.lookupPacientes.push({id: item.id_paciente, nome: item.paciente_nome})
                this.dialogEditPassageiro = true;
            },

            // faz a busca de pacientes no autocomplete
            getPacientesLookup: function (val) {
                let vm = this;
                axios
                    .get('http://localhost:8000/api/pacientes?search='+vm.searchPacientes)
                    .then(function(response) {
                        vm.lookupPacientes = response.data.data
                    })
                    .catch(function(error) {
                        console.error(error)
                    })
                    .finally(() => (vm.loadingPacientes = false))
            },

            // isso serve pra não fazer request a cada letra digitada, mas sim, após um tempo sem digitar
            _debounce(){
                this.loadingPacientes = true;
                if (this.timeoutId !== null) {
                    clearTimeout(this.timeoutId);
                }
                this.timeoutId = setTimeout( _ => {
                    this.getPacientesLookup();
                }, 1400);
            },
        },

        watch: {
            // quando a prop dialogList é true, está abrindo o dialog, senão está fechando
            dialogList: function(val) {
                if (val) this.initialize();
            },
        },
    }
</script>