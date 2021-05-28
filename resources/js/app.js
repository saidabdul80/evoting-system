/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'   
import Vuex from 'vuex'
import axios from 'axios'
import storedata from "./store/index";
import VueAxios from 'vue-axios'
import bootstrap from "bootstrap";

window.Vue = Vue;

Vue.use(Vuex)
Vue.use(VueAxios, axios);
const store = new Vuex.Store(storedata)
Vue.prototype.$eventBus = new Vue();
 

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('voting-stage', require('./components/voting.vue').default);
Vue.component('dashboard-stage', require('./components/dashboard.vue').default);
Vue.component('results-stage', require('./components/result.vue').default);

 
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    bootstrap   
});
