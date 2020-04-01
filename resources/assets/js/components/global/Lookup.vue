<template>  
</template>

<script>
    export default {
        methods: { 
            
            getLookup (dataset, search) {

                let api = null;
                let vm = this;

                if (dataset == 'VEICULO')   api = 'http://localhost:8000/api/veiculos';
                if (dataset == 'MOTORISTA') api = 'http://localhost:8000/api/motoristas';
                if (dataset == 'MUNICIPIO') api = 'http://localhost:8000/api/municipios';
                if (dataset == 'PACIENTE')  api = 'http://localhost:8000/api/pacientes?search='+search

                axios
                    .get(api)
                    .then(function(response) {
                        console.log('response', response)
                        if (response.data.error) {
                            console.log('error', response.data.error)
                            vm.$emit('updateLookup', dataset, []);
                        } else {
                            vm.$emit('updateLookup', dataset, response.data.data)
                        }
                    })
                    .catch(function(error) {
                        console.log(error)
                        vm.$emit('updateLookup', dataset, [])
                    })
            },
        },
    }
</script>