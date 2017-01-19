
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const VueRouter =  require('vue-router');
Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const navComponent = Vue.component('topnav', require('./components/topnav.vue'));

const indexComponent = Vue.component('index', require('./components/index.vue'));
const loginComponent = Vue.component('login', require('./components/login.vue'));
const reginComponent = Vue.component('regin', require('./components/regin.vue'));

const routes = [
    { path: '/', component: indexComponent },
    { path: '/login', component: loginComponent },
    { path: '/regin', component: reginComponent },
];

const router = new VueRouter({
    routes // （缩写）相当于 routes: routes,
});

const app = new Vue({
    el: '#app',
    router
});
