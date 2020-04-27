require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify';
import VuetifyToast from 'vuetify-toast-snackbar'

Vue.use(Vuetify);
Vue.use(VuetifyToast, {
  color: 'info',
  iconColor: 'transparent' ,
  showClose: true,
  closeIcon: 'mdi-close',
  timeout: 5000,
  x: 'center',
  y: 'bottom',
})

// global
Vue.component('navigation', require('./components/global/Navigation.vue'));
Vue.component('lookup',     require('./components/global/Lookup.vue'));

// cadastros
Vue.component('motoristas', require('./components/Motoristas.vue'));
Vue.component('veiculos',   require('./components/Veiculos.vue'));
Vue.component('pacientes',  require('./components/Pacientes.vue'));

// viagens
Vue.component('viagens',        require('./components/viagem/Index.vue'));
Vue.component('viagem-edit',    require('./components/viagem/Edit.vue'));
Vue.component('viagem-list',    require('./components/viagem/Lista.vue'));

// admin
Vue.component('admin-unidade',  require('./components/admin/Unidades.vue'));
Vue.component('admin-usuario',  require('./components/admin/Usuarios.vue'));
Vue.component('admin-reports',  require('./components/admin/Reports.vue'));
Vue.component('admin-logs',     require('./components/admin/Logs.vue'));

// public
Vue.component('auth-login',     require('./components/public/Login.vue'));
Vue.component('chamada',        require('./components/public/Chamada.vue'));

//dashboard
Vue.component('dashboard',                  require('./components/dashboard/Index.vue'));
Vue.component('dashboard-top5',             require('./components/dashboard/Top5.vue'));
Vue.component('dashboard-stats',            require('./components/dashboard/Stats.vue'));
Vue.component('dashboard-graph-pacientes',  require('./components/dashboard/GraphPacientes.vue'));
Vue.component('dashboard-graph-viagens',    require('./components/dashboard/GraphViagens.vue'));
Vue.component('dashboard-next-viagens',     require('./components/dashboard/NextViagens.vue'));
Vue.component('dashboard-absenteism',       require('./components/dashboard/Absenteism.vue'));

/*
 * Tempo de debounce para autocompletes
 */
Vue.prototype.$debounceTime = 1200;

/*
 * Apenas abre uma URL em target _blank
 */
Vue.prototype.$openBlank = function (url) {
  window.open(url,'_blank')
},

/*
 * Abre um popup centralizado na tela
 */
Vue.prototype.$openPopup = function (url, title) {
  
  let windowWidth = window.innerWidth - 200;
  let windowHeight = window.innerHeight - 100;
  let left = (window.innerWidth / 2) - (windowWidth / 2)
  let popupParams = `width=${windowWidth}, height=${windowHeight}, top=50, left=${left}`;

  let popup = window.open(url, title, popupParams);
  if (!popup || popup.closed || typeof popup.closed=='undefined') { 
      window.open(url, 'blank')
  }
}

const app = new Vue({
  el: '#app',
  vuetify: new Vuetify({
    theme: {
      themes: {
        light: {
          primary: '#17234e',
          secondary: '#0b51c5',
          accent: '#0091EA'
        },
      },
    },
  }),
});