
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// import * as OfflinePluginRuntime from 'offline-plugin/runtime';
// OfflinePluginRuntime.install();

// import VueLocalStorage from 'vue-localstorage';
// Vue.use(VueLocalStorage);

import store from './store/index.js';
import AppDrawer from './components/AppDrawer.vue';
import VueRouter from 'vue-router';


Vue.use(VueRouter);

import router from './router/index.js';



const app = new Vue({
    el: '#app',
    components: { AppDrawer },
    store,
    router
});
