<template>
  
    <v-row>
      <v-col cols="9">
        <v-card class="pa-4" >
        <v-sparkline
          :value="value"
          :gradient="gradient"
          :smooth="radius || false"
          :padding="padding"
          line-width="2"
          :stroke-linecap="lineCap"
          :gradient-direction="gradientDirection"
          :type="type"
          auto-draw
          show-labels
          label-size="4"
        ></v-sparkline>
  </v-card>

      </v-col>
      <v-col>
        <v-card dark color="primary" height="100%">
          <v-card-title>PRÓXIMAS VIAGENS</v-card-title>
          <v-card-text> Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, ex quam! Ratione magni ex quibusdam, in, ipsam assumenda dolores iste amet minima eligendi quo itaque temporibus error consequuntur sed odit? </v-card-text>
          <v-card-actions>
            <v-btn text>Faça qualquer coisa</v-btn>
          </v-card-actions>
        </v-card>

      </v-col>
    
    </v-row>
</template>

<script>
  const gradients = [
    ['#222'],
    ['#42b3f4'],
    ['red', 'orange', 'yellow'],
    ['purple', 'violet'],
    ['#00c6ff', '#F0F', '#FF0'],
    ['#f72047', '#ffd200', '#1feaea'],
  ]

  export default {
    data: () => ({
      radius: 10,
      padding: 8,
      lineCap: 'round',
      gradient: gradients[5],
      value: [0, 2, 5, 9, 5, 10, 3, 5, 0, 0, 1, 8, 2, 9, 0],
      gradientDirection: 'top',
      gradients,
      type: 'trend',
    }),
  }
</script>