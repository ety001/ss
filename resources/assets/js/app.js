
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const VueRouter =  require('vue-router');
Vue.use(VueRouter);

const VueResource = require('vue-resource');
Vue.use(VueResource);
Vue.http.options.root = '/api';//the api url is base on /api

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
    { path: '/', component: indexComponent, meta: { requiresAuth: false } },
    { path: '/login', component: loginComponent, meta: { requiresAuth: false } },
    { path: '/regin', component: reginComponent, meta: { requiresAuth: false } },
];

const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!auth.loggedIn()) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else {
        next();
    }
});

const app = new Vue({
    el: '#app',
    data: {
    },
    router,
    methods: {

    }
});
