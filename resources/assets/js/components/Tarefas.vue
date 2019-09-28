<template>
    <div>
        <ul>
            <li v-for="(t, index) in tarefas" :key="index">  
                {{t.id}} - {{t.descricao}} - {{t.concluida}} - {{t.created_at}}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'tarefas',
        data() {
            return {
                tarefas: []
            }
        },

        mounted() {
            this.getTarefas();
            console.log(this.tarefas)
        },

        methods: {
            getTarefas () {
                let vm = this;
                axios
                .get('http://localhost:8000/tarefas/json')
                .then(function(resposta) {
                    vm.tarefas = (resposta.data)
                })
                .catch(function(error) {
                    //console.log(error);
                })
                .finally(function() {
                    //console.log(error);
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
$cor: #111;

ul {
    background: yellow;
    li {
        background: $cor;
        color: #fff;
    }
}
</style>
