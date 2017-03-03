<template>
    <div class="row marketing">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="form">
                        <div class="form-group">
                            <label for="username">用户名</label>
                            <input type="text" class="form-control" @keyup.enter="login" v-model="userinfo.username">
                        </div>
                        <div class="form-group">
                            <label for="password">密码</label>
                            <input type="password" class="form-control" @keyup.enter="login" v-model="userinfo.password">
                        </div>
                        <button class="btn btn-primary" @click="login">登录</button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-8 col-md-offset-2">
                    <transition name="fade">
                        <alert-component :displayTag="alertDisplay" :className="alertStatus">{{ alertMsg }}</alert-component>
                    </transition>
                </div>
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script>
    import alertComponent from './common/alert.vue';

    export default {
        data() {
            return {
                userinfo: {
                    username: '',
                    password: ''
                },
                alertDisplay: false,
                alertMsg: '',
                alertStatus: ''
            }
        },
        components: {
            'alert-component': alertComponent
        },
        methods: {
            login() {
                var that = this;
                this.$http.post('login', this.userinfo).then(res => {
                    switch (res.status) {
                        case 200:
                            var resBody = res.body;
                                switch (resBody.status) {
                                    case true:
                                        this.alert(resBody.msg[0], 'success', '/#/user', 4000);
                                        break;
                                    case false:
                                        var msg = [];
                                        for(var i in resBody.msg){
                                            msg.push(resBody.msg[i]);
                                        }
                                        this.alert(msg.join(', '), 'danger');
                                        break;
                                }
                            break;
                    }
                }, err_res => {
                    // error callback
                    switch (err_res.status) {
                        case 500:
                            console.log('服务端错误');
                            break;
                        default:

                    }
                });
                //console.log('hello world', this.userinfo);
            },
            alert(msg, status, jump, timeout) {
                var that = this;
                this.alertDisplay = true;
                this.alertMsg = msg;
                this.alertStatus = status;
                setTimeout(function(){
                    that.alertDisplay = false;
                    that.alertMsg = '';
                    that.alertStatus = '';
                    if(jump!=undefined) {
                        window.location = jump;
                    }
                }, timeout ? timeout : 5000);
            }
        }
    }
</script>
