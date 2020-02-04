<template>
  <div>
    <v-content>
      <v-container fluid>
      	  <v-simple-table fixed-header height="80vh">
      	    <template v-slot:default>
      	      <thead>
      	        <tr>
      	          <th class="text-left">#</th>
      	          <th class="text-left">Name</th>
      	          <th class="text-left">Telefone</th>
      	          <th class="text-left">Createdat</th>
      	          <th></th>
      	        </tr>
      	      </thead>
      	      <tbody>
      	        <tr v-for="(motorista, i) in motoristas" :key="i">
      	          <td>{{ motorista.id }}</td>
      	          <td>{{ motorista.nome }}</td>
      	          <td>{{ motorista.telefone }}</td>
      	          <td>{{ motorista.created_at }}</td>
      	          <td>
      	          	<v-btn class="ma-2" text icon color="blue darken-1" @click.stop="beginEdit(motorista)">
				        <v-icon>mdi-pencil</v-icon>
				    </v-btn>
      	          	<v-btn class="ma-2" text icon color="red darken-1" @click.stop="beginDelete(motorista, i, false)">
				        <v-icon>mdi-delete</v-icon>
				    </v-btn>
      	        </td>
      	        </tr>
      	      </tbody>
      	    </template>
      	  </v-simple-table>
      </v-container>
    </v-content>



    <v-snackbar v-model="snackbar" :color="'success'"> Motorista deletado com sucesso!</v-snackbar>





    <v-dialog v-model="dialogDelete" max-width="290">
      <v-card>
        <v-card-title class="headline">Confirmar exclusão?</v-card-title>
        <v-card-text>
          Tem certeza que deseja deletar o motorista {{ deleteSelected.nome }} ?
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Não
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="beginDelete(deleteSelected, deleteIndexSelected, true)"
          >
            Sim
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>






    <v-dialog v-model="dialogEdit" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="headline">Motorista</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="12" md="6">
                <v-text-field v-model="editSelected.nome" label="Nome" required></v-text-field>
              </v-col>
              <v-col cols="12" sm="12" md="6">
                <v-text-field v-model="editSelected.telefone" label="Telefone" hint="Digite seu telefone"></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialogEdit = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="dialogEdit = false">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


  </div>
</template>

<script>
  export default {
  	props: {
      data: Array,
    },
    data: () => ({
    	motoristas: [],

      	deleteSelected: [],
      	editSelected: [],
      	deleteIndexSelected: null,

      	dialogDelete: false,
      	dialogEdit: false,
      	snackbar: false,
      
    }),
    mounted() {
    	console.log(this.data)
    	this.motoristas = this.data
    },
    methods: {
    	beginDelete(motorista, index, confirm) {
    		
    		if (!confirm) {
    			this.deleteSelected = motorista
    			this.deleteIndexSelected = index
    			this.dialogDelete = true
    			return;
    		}

    		Vue.delete(this.motoristas, this.deleteIndexSelected)
    		this.dialogDelete = false;

    		this.snackbar = true;
    	},

    	beginEdit(motorista) {
    		this.dialogEdit = true
    		this.editSelected = motorista
    	}
    }
  }
</script>