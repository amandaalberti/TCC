
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import datePicker from 'vue-bootstrap-datetimepicker';
import 'bootstrap/dist/css/bootstrap.css';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
Vue.use(datePicker);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('loading', require('./components/loading.vue'));
Vue.component('exercicios', require('./components/exercicios/principal.vue'));
Vue.component('exercicioPalavraCorrespondente', require('./components/exercicios/palavraCorrespondente.vue'));
Vue.component('exercicioQuantidadeSilabas', require('./components/exercicios/quantSilabas.vue'));
Vue.component('exercicioLetraFaltante', require('./components/exercicios/letraFaltante.vue'));

const app = new Vue({
    el: '#app'
});


$(function(){
	$('.letra').on('click', function(){
		var letra = $(this).find('span').text();
		window.location = window.addr + '/opcoes/' + letra;
	});

	$('.opcao').on('click', function(){
		window.location = $(this).find('a').attr('href');
	});
});