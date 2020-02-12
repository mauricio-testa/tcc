
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

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
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// global
Vue.component('navigation', require('./components/global/Navigation.vue'));

// views
Vue.component('motoristas', require('./components/Motoristas.vue'));
Vue.component('veiculos', require('./components/Veiculos.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});