<template>
  <div>
    <v-content>
      <v-container fluid>
        <v-card class="ml-2 mt-2 px-2">

          <!-- table  -->
          <v-data-table
            :headers="headers"
            :items="motoristas"
            :loading="loading"
          >
            <!-- table toolbar -->
            <template v-slot:top>
              <v-toolbar flat color="white">
                <v-toolbar-title>Motoristas</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn color="primary" dark class="mb-2" @click="addNew">Novo Motorista</v-btn>
              </v-toolbar>
            </template>

            <!-- table actions -->
            <template v-slot:item.action="{ item }">
              <v-icon class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
              <v-icon @click="deleteItem(item, false)">mdi-delete</v-icon>
            </template>
          </v-data-table>

        </v-card>
      </v-container>
    </v-content>

    <!-- dialog delete -->
    <v-dialog v-model="dialogDelete" max-width="290">
      <v-card>
        <v-card-title class="headline">Confirmar exclusão?</v-card-title>
        <v-card-text>Tem certeza que deseja deletar o motorista "{{ selectedItem.nome }}"?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialogDelete = false">Cancelar</v-btn>
          <v-btn color="red darken-1" text @click="deleteItem(selectedIndex, true)">Excluir</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- dialog edit / new -->
    <v-dialog v-model="dialogEdit" max-width="500px">
      <v-form v-model="formValid" ref="formEdit">
        <v-card>
          <v-card-title>
            <span class="headline">Motorista</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field v-model="selectedItem.nome" label="Nome" required :rules="[v => !!v || 'Nome é obrigatório']"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <v-text-field v-mask="'(##) #####-####'" v-model="selectedItem.telefone" :rules="[v => (v ? (v.length > 14) : !v) || 'Telefone deve ter 11 números']" label="Telefone"></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="dialogEdit = false">Cancelar</v-btn>
            <v-btn color="blue darken-1" text @click="save">Salvar</v-btn>
          </v-card-actions>
        </v-card>
      </v-form>
    </v-dialog>

  </div>
</template>

<script>
  import {TheMask} from 'vue-the-mask'

  export default {
    props: ['api'],
    components: {TheMask},

    data: () => ({
      // main data
      motoristas: [],

      // state of elements
      dialogDelete: false,
      dialogEdit: false,
      loading: true,
      formValid: true,

      // table column names
      headers: [
          { text: '#', value: 'id'},
          { text: 'Nome', value: 'nome' },
          { text: 'Telefone', value: 'telefone' },
          { text: 'Data Criação', value: 'created_at' },
          { text: 'Ações', value: 'action' },
        ],
      
      // CRUD variables
      selectedIndex: null,
      selectedItem: {
        nome: null,
        telefone: null,
      },
      defaultItem: {
        nome: null,
        telefone: null,
      },
    }),

    mounted() {
      this.getMotoristas();
    },

    methods: {

      /*
       * Faz o fetch da lista de motoristas a partir da API
       */

      getMotoristas() {
        let vm = this;
        vm.loading = true;
        axios
          .get(this.api)
          .then(function(response) {
            vm.motoristas = response.data;
          })
          .catch(function(error) {
            vm.$toast.error('Erro ao buscar motoristas')
          })
          .finally(function() {
            vm.loading = false;
          });
      },

      /*
       * Abre o modal de edição a partir da coluna "Ações da tabela"
       * @param item obj
       */

      editItem (item) {
        this.selectedIndex = this.motoristas.indexOf(item)
        this.selectedItem = Object.assign({}, item)
        this.dialogEdit = true
      },

      /*
       * Salvar item editado ou novo
       * Se tiver index é edição, senão é novo registro
       */

      save () {
        if (!this.$refs.formEdit.validate()) return;
        let vm = this;
        // EDIÇÃO
        if (this.selectedIndex > -1) {
          axios
            .put(this.api+'/'+this.selectedItem.id, vm.selectedItem)
            .then(function(response){
                if(response.data.error) {
                  vm.$toast.error('Erro ao editar motorista: '+response.data.error)
                }
                else {
                  Object.assign(vm.motoristas[vm.selectedIndex], vm.selectedItem)
                  vm.dialogEdit = false;
                  vm.$toast.success('Motorista salvo com sucesso!')
                }
            })
        // NOVO
        } else {
          axios
            .post(this.api, {
              'nome'      : vm.selectedItem.nome,
              'telefone'  : vm.selectedItem.telefone
            })
            .then(function(response){
                if(response.data.error) {
                  vm.$toast.error('Erro ao cadastrar motorista: '+response.data.error)
                }
                else {
                  vm.getMotoristas();
                  vm.dialogEdit = false;
                  vm.$toast.success('Motorista cadastrado com sucesso!')
                }
            })
        }
      },

      /*
       * Abre modal e assinala index nulo e valores padrão para inserir novo registro
       */

      addNew () {
        this.dialogEdit = true
        this.selectedItem = Object.assign({}, this.defaultItem)
        this.selectedIndex = -1
      },

      /*
       * Exclui um registro
       * @param item Obj
       * @param confirm bool
       * Ao clicar nas ações da tabela o parametro confirm vem false e abre o dialog de confirmação
       * Para ficar true é necessário confirmar no dialog que abre posteriormente
       */

      deleteItem (item, confirm) {
        
        if (!confirm) {
          this.selectedItem = item;
          this.selectedIndex = this.motoristas.indexOf(item);
    			this.dialogDelete = true
    			return;
        }

        let vm = this;
        axios
          .delete(this.api+'/'+this.selectedItem.id)
          .then(function(response){
            if(response.data.error) {
              vm.$toast.error('Erro ao deletar motorista: '+response.data.error)
            }
            else {
              vm.$toast.success('Motorista deletado com sucesso!')
              vm.motoristas.splice(vm.selectedIndex, 1)
            }
          })
          .finally(function() {
              vm.dialogDelete = false;
          });
      },
    }
  }
</script>