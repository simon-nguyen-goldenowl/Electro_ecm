/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import router from "./router";
import axios from 'axios'
import VueCookies from 'vue-cookies'
import MainApp from './MainApp';
Vue.use(VueCookies);
require('./bootstrap');
const app = new Vue({
    el: '#app',
    components: {
        MainApp,
    },
    router,
    axios,
});


