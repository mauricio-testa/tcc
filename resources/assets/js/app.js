
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
	x: 'right', // default
	y: 'bottom', // default
	color: 'info',
    iconColor: 'transparent' ,
	queueable: false, // default
	showClose: true,
	closeIcon: 'mdi-close', // default
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('navigation', require('./components/global/navigation.vue'));
Vue.component('motoristas', require('./components/motoristas.vue'));
Vue.component('example', require('./components/Example.vue'));
Vue.component('tarefas', require('./components/Tarefas.vue'));

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});