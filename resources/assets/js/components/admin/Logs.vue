<template>
    <div>
        <v-card class="ma-md-2 px-2 ma-xs-0">
            <v-row>
                <v-col cols="8">
                    <!-- table header -->
                    <v-card-title>
                        <v-row>
                        <v-col cols="12" md="8">
                            Logs
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
                        :items="logs"
                        :loading="loading.list"
                        hide-default-footer
                        disable-sort
                        no-data-text="Nenhum dado encontrado."
                        loading-text="Buscando dados..."
                    >
                    </v-data-table>

                    <div class="text-center py-3">
                        <v-pagination
                            v-model="pagination.current"
                            :length="pagination.total"
                            @input="onPageChange"
                            circle
                        ></v-pagination>
                    </div>
                </v-col>
                <v-col cols="4">
                    View
                </v-col>
            </v-row>
        
    </v-card>
    </div>
</template>

<script>

    export default {
    
        data: () => ({
            
            // main data
            logs: [],
            api: window.__routes.api.log,

            loading: {
                list: false,
            },

            // table column names
            headers: [
                { text: '#', value: 'id'},
                { text: 'Level', value: 'level'},
                { text: 'Mensagem', value: 'message'},
            ],

            // server side pagination
            pagination: {
                current: 1,
                total: 0,
                totalItems: 0,
                perPage: 0,
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

                if(vm.searchWord != null && vm.searchWord != '') urlFetch+= '&search='+vm.searchWord;

                vm.loading.list = true;

                axios
                    .get(urlFetch)
                    .then(function(response) {
                        vm.logs                   = response.data.data;
                        vm.pagination.current     = response.data.current_page;
                        vm.pagination.total       = response.data.last_page;
                        vm.pagination.totalItems  = response.data.total;
                        vm.pagination.perPage     = response.data.per_page;
                        
                    })
                    .catch(function(error) {
                        vm.$toast.error('Erro ao buscar logs')
                    })
                    .finally(() => { vm.loading.list = false; });
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