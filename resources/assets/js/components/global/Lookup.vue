<template>  
</template>

<script>
    export default {
        methods: { 
            
            getLookup (dataset, search) {

                let api = null;
                let vm = this;

                if (dataset == 'VEICULO')   api = window.__routes.api.veiculo;
                if (dataset == 'MOTORISTA') api = window.__routes.api.motorista;
                if (dataset == 'MUNICIPIO') api = window.__routes.api.municipio;
                if (dataset == 'PACIENTE')  api = window.__routes.api.paciente+'?search='+search

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