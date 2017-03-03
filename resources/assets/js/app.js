
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueCookie from 'vue-cookie';
Vue.use(VueCookie);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const navComponent = Vue.component('topnav', require('./components/topnav.vue'));

const indexComponent = Vue.component('index', require('./components/index.vue'));
const loginComponent = Vue.component('login', require('./components/login.vue'));
const reginComponent = Vue.component('regin', require('./components/regin.vue'));
const userComponent = Vue.component('user', require('./components/user.vue'));

const routes = [
    { path: '/', component: indexComponent, meta: { requiresAuth: false } },
    { path: '/login', component: loginComponent, meta: { requiresAuth: false } },
    { path: '/regin', component: reginComponent, meta: { requiresAuth: false } },
    { path: '/user', component: userComponent, meta: { requiresAuth: true } },
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
