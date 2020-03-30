<template>
    <div>
        <v-card class="ma-md-2 px-2 ma-xs-0">
        <!-- table header -->
        <v-card-title>
            <v-row>
            <v-col cols="12" md="8">
                Viagens
                <v-btn class="ml-4" fab dark small color="primary" @click="addNew">
                <v-icon dark>mdi-plus</v-icon>
                </v-btn>
            </v-col>
            <v-col cols="12" md="4">
                <v-form @submit.prevent="search()">
                <v-text-field 
                    v-model="searchWord" 
                    :prepend-icon="'mdi-magnify'"
                    @click:clear="resetSearch()"
                    :hint="'Digite sua busca e tecle Enter!'"
                    label="Pesquisar"
                    clearable
                    >
                </v-text-field>
                </v-form>
            </v-col>
            </v-row>                        
        </v-card-title>

        <!-- table  -->
        <v-data-table
            :headers="headers"
            :items="viagens"
            :loading="loading"
            hide-default-footer
            disable-sort
            no-data-text="Nenhum dado encontrado."
            loading-text="Buscando dados..."
        >
            <!-- table actions -->
            <template v-slot:item.action="{ item }">
                <v-icon class="mr-2" color="blue darken-1" text @click="editItem(item)">mdi-pencil</v-icon>
                <v-tooltip top>
                    <template v-slot:activator="{ on }">
                        <v-icon class="mr-2" v-on="on" color="indigo darken-1" text @click="listPassageiros(item)">mdi-view-list</v-icon>
                    </template>
                    <span>Lista de Passageiros</span>
                </v-tooltip>
                <v-icon color="red darken-1" @click="deleteItem(item, false)">mdi-delete</v-icon>
            </template>
        </v-data-table>

        <div class="text-center py-3">
            <v-pagination
                v-model="pagination.current"
                :length="pagination.total"
                @input="onPageChange"
                circle
            ></v-pagination>
        </div>
        </v-card>

        <!-- dialog delete -->
        <v-dialog v-model="dialogDelete" max-width="290">
        <v-card>
            <v-card-title class="headline">Confirmar exclusão?</v-card-title>
            <v-card-text>Tem certeza que deseja deletar a viagem para {{selectedViagem.municipio_nome}} em {{selectedViagem.data_formated}}?</v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialogDelete = false">Cancelar</v-btn>
                <v-btn color="red darken-1" text @click="deleteItem(selectedIndex, true)">Excluir</v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>

        <!-- dialog edit / new -->
        <viagem-edit :viagem="selectedViagem" :dialogEdit.sync="dialogEdit"></viagem-edit>
        <viagem-list :viagem="selectedViagem" :dialogList.sync="dialogList"></viagem-list>

    </div>
</template>

<script>

    export default {
    
        props: ['api'],

        data: () => ({
            
            // main data
            viagens: [],

            // state of elements
            dialogDelete: false,
            dialogEdit: false,
            dialogList: false,
            loading: true,
            formValid: true,

            // table column names
            headers: [
                { text: '#', value: 'id'},
                { text: 'Data', value: 'data_formated'},
                { text: 'Destino', value: 'municipio_nome'},
                { text: 'Veículo', value: 'veiculo'},
                { text: 'Motorista', value: 'motorista_nome'},
                { text: 'Ações', value: 'action'},
            ],

            // server side pagination
            pagination: {
                current: 1,
                total: 0,
                totalItems: 0,
                perPage: 0,
            },
            
            // CRUD variables
            selectedIndex: null,
            selectedViagem: {
                id: null,
            },
            defaultItem: {
                id: null,
            },
            searchWord: null,
        }),

        mounted() {

            this.getItems();

        },

        methods: { 

        getItems: function() {

            let vm        = this;
            let page      = vm.pagination.current;
            let urlFetch  = this.api+'?page='+page;

            // if(vm.searchWord != null && vm.searchWord != '') urlFetch+= '&search='+vm.searchWord;

            vm.loading = true;

            axios
                .get(urlFetch)
                .then(function(response) {
                    vm.viagens                = response.data.data;
                    vm.pagination.current     = response.data.current_page;
                    vm.pagination.total       = response.data.last_page;
                    vm.pagination.totalItems  = response.data.total;
                    vm.pagination.perPage     = response.data.per_page;
                    
                })
                .catch(function(error) {
                    vm.$toast.error('Erro ao buscar viagens')
                })
                .finally(function() {
                    vm.loading = false;
                });
            },

            /*
            * Salvar item editado ou novo
            * Se tiver index é edição, senão é novo registro
            */

            /*
            save: function () {

                if (!this.$refs.formEdit.validate()) return;
                let vm = this;
                
                if (this.selectedIndex > -1) {
                axios
                    .put(this.api+'/'+this.selectedViagem.id, vm.selectedViagem)
                    .then(function(response){
                        if(response.data.error) {
                        vm.$toast.error('Erro ao editar: '+response.data.error)
                        }
                        else {
                        Object.assign(vm.viagens[vm.selectedIndex], vm.selectedViagem)
                        vm.dialogEdit = false;
                        vm.$toast.success('Viagem salva com sucesso!')
                        }
                    })

                } else {
                axios
                    .post(this.api, {
                        'nome'      : vm.selectedViagem.nome,
                        'telefone'  : vm.selectedViagem.telefone
                    })
                    .then(function(response){
                        if(response.data.error) {
                            vm.$toast.error('Erro ao cadastrar: '+response.data.error)
                        }
                        else {
                            // item adicionado vai sempre por último
                            vm.pagination.current = parseInt(vm.pagination.totalItems / vm.pagination.perPage) + 1;
                            vm.getItems();
                            vm.dialogEdit = false;
                            vm.$toast.success('Viagem cadastrada com sucesso!')
                        }
                    })
                }
            },
            */

            /*
            * Exclui um registro
            * @param item Obj
            * @param confirm bool
            * Ao clicar nas ações da tabela o parametro confirm vem false e abre o dialog de confirmação
            * Para ficar true é necessário confirmar no dialog que abre posteriormente
            */

            deleteItem: function (item, confirm) {
                
                if (!confirm) {
                    this.selectedViagem = item;
                    this.selectedIndex = this.viagens.indexOf(item);
                    this.dialogDelete = true
                    return;
                }

                let vm = this;
                axios
                    .delete(this.api+'/'+this.selectedViagem.id)
                    .then(function(response){
                        if(response.data.error) {
                            vm.$toast.error('Erro ao deletar: '+response.data.error)
                        }
                        else {
                            vm.$toast.success('Viagem deletada com sucesso!')
                            vm.viagens.splice(vm.selectedIndex, 1)
                            // utilizado para carregar a paginação correta após adicionar
                            vm.pagination.totalItems--;
                            //se for último da paginação e tiver mais paginações, dá reload
                            if (vm.viagens.length == 0 && vm.pagination.current > 1){
                                vm.pagination.current--;
                                vm.getItems()
                            }
                        }
                    })
                .finally(function() {
                    vm.dialogDelete = false;
                });
            },

            // Abre modal e assinala index nulo e valores padrão para inserir novo registro
            addNew: function () {
                this.selectedViagem = Object.assign({}, this.defaultItem);
                this.selectedIndex = -1;
                this.dialogEdit = true;
            },

            // Abre o modal de edição a partir da coluna "Ações da tabela"
            editItem: function (item) {
                this.selectedIndex = this.viagens.indexOf(item);
                this.selectedViagem = Object.assign({}, item);
                this.dialogEdit = true;
            },

            listPassageiros: function(item) {
                this.selectedIndex = this.viagens.indexOf(item);
                this.selectedViagem = Object.assign({}, item);
                this.dialogList = true;
            },

            // Inicia uma pesquisa
            search: function () {
                this.pagination.current = 1;
                this.getItems();
            },

            // Limpa a pesquisa
            resetSearch: function () {
                this.pagination.current = 1;
                this.searchWord = null;
                this.getItems();
            },

            // A cada clique na paginação, recarrega a lista. Se tivre filtro vai persistir
            onPageChange: function () {
                this.getItems();
            },
        }
    }
</script>