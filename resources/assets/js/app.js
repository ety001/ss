
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

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
const payComponent = Vue.component('pay', require('./components/pay.vue'));
const serviceComponent = Vue.component('service', require('./components/service.vue'));
const downloadComponent = Vue.component('download', require('./components/download.vue'));
const exitComponent = Vue.component('exit', require('./components/exit.vue'));

const routes = [
    { path: '/', component: indexComponent, meta: { requiresAuth: false } },
    { path: '/login', component: loginComponent, meta: { requiresAuth: false } },
    { path: '/regin', component: reginComponent, meta: { requiresAuth: false } },
    { path: '/user', component: userComponent, meta: { requiresAuth: true } },
    { path: '/pay', component: payComponent, meta: { requiresAuth: true } },
    { path: '/service', component: serviceComponent, meta: { requiresAuth: true } },
    { path: '/download', component: downloadComponent, meta: { requiresAuth: true } },
    { path: '/exit', component: exitComponent, meta: { requiresAuth: true } },
];

const router = new VueRouter({
    routes
});

router.beforeEach((to, from, next) => {
    if ( to.matched.some(record => record.meta.requiresAuth) ) {
        if (!router.app.login_status) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else {
        if (router.app.login_status) {
            next({
                path: '/user'
            });
        } else {
            next();
        }
    }
});

const app = new Vue({
    el: '#app',
    data: {
        login_status: false
    },
    router,
    methods: {
        authToken () {
            let user_token = this.$cookies.get('user_token');
            if(user_token) {
                axios.post('auth', {api_token: user_token})
                    .then(res => {
                        switch (res.status) {
                            case 200:
                                let resBody = res.data;
                                switch (resBody.status) {
                                    case true:
                                        this.login_status = true;
                                        break;
                                    case false:
                                        this.login_status = false;
                                        break;
                                }
                                break;
                        }
                    })
                    .catch(err_res => {
                        this.login_status = false;
                    });
            } else {
                return false;
            }
        }
    },
    watch: {
        login(val) {
            if(val==true){
                this.$router.push({path:'user'});
            }
        }
    },
    created () {
        // 创建完后获取数据
        this.authToken();
    },
    delimiters: ['${', '}']
});
