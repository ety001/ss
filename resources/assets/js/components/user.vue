<template>
    <div class="row marketing">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="success">
                                <td>用户登录名</td>
                                <td>{{ username }}</td>
                            </tr>
                            <tr class="success">
                                <td>用户类型</td>
                                <td>{{ user_type }}</td>
                            </tr>
                            <tr class="success">
                                <td>用户余额</td>
                                <td>
                                    <code>{{ money_amount }}</code> RMB
                                    <router-link to="/pay">充值</router-link>
                                </td>
                            </tr>
                            <tr class="warning">
                                <td>服务状态</td>
                                <td v-if="current_service">
                                    已开通服务 <code>{{ current_service.service.service_name }}</code>
                                </td>
                                <td v-else>
                                    还未开通服务，
                                    <router-link to="/service">点击这里</router-link>
                                    去购买服务
                                </td>
                            </tr>
                            <tr class="warning">
                                <td>服务开始时间</td>
                                <td v-if="current_service">
                                    {{ current_service.buy_time }}
                                </td>
                                <td v-else>
                                    --
                                </td>
                            </tr>
                            <tr class="warning">
                                <td>服务到期时间</td>
                                <td v-if="current_service">
                                    {{ current_service.end_time }}
                                </td>
                                <td v-else>
                                    --
                                </td>
                            </tr>
                            <tr class="warning">
                                <td>服务运行状态</td>
                                <td v-if="current_service">
                                    <template>
                                        <code>正在运行</code>
                                    </template>
                                    <template>
                                        <code>已停止</code>
                                        <button class="btn btn-mini">启动</button>
                                    </template>
                                </td>
                                <td v-else>
                                    还未开通服务，
                                    <router-link to="/service">点击这里</router-link>
                                    去购买服务
                                </td>
                            </tr>
                            <tr class="info">
                                <td>Shadowsocks 服务器地址</td>
                                <td><code>gfw1.fuckspam.in</code></td>
                            </tr>
                            <tr class="info">
                                <td>Shadowsocks 服务器端口</td>
                                <td><code>{{ ssport }}</code></td>
                            </tr>
                            <tr class="info">
                                <td>Shadowsocks 服务器密码</td>
                                <td><code>{{ sspass }}</code></td>
                            </tr>
                            <tr class="info">
                                <td>Shadowsocks 服务器加密方式</td>
                                <td><code>aes-256-cfb</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" v-if="email_chk == 0">
                <div class="col-md-8 col-md-offset-2">
                    <div class="form">
                        <input class="form-control" type="email" id="email" v-model="email"><br>
                        <input class="form-control btn btn-primary" type="submit" value="重发验证邮件">
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
                username : null,
                user_type : null,
                ssport: null,
                sspass: null,
                money_amount : null,
                current_service : null,
                service_status: null,
                email: null,
                email_chk: 0,
                alertDisplay: false,
                alertMsg: '',
                alertStatus: '',
            }
        },
        components: {
            'alert-component': alertComponent
        },
        methods: {
            update_data(data) {
                this.username = data.username;
                this.email = data.email;
                this.email_chk = data.email_chk;
                this.user_type = data.user_type;
                this.ssport = data.ssport;
                this.sspass = data.sspass;
                this.money_amount = data.money_amount;
                this.current_service = data.current_service;
                this.service_status = data.service_status;
            },
            alert(msg, status, jump, timeout) {
                let that = this;
                this.alertDisplay = true;
                this.alertMsg = msg;
                this.alertStatus = status;
                setTimeout(function(){
                    that.alertDisplay = false;
                    that.alertMsg = '';
                    that.alertStatus = '';
                    if(jump!=undefined) {
                        that.$router.push({ path: jump });
                    }
                }, timeout ? timeout : 5000);
            }
        },
        created() {
            let user_token = this.$cookies.get('user_token');
            let that = this;
            axios.post('user', {api_token: user_token})
                .then(res => {
                    //console.log(res);
                    switch (res.status) {
                        case 200:
                            let data = res.data;
                            switch (data.status) {
                                case true:
                                    that.update_data(data.data);
                                    break;
                                case false:

                                    break;
                            }
                            break;
                    }
                })
                .catch(err_res => {
                    console.log(err_res);
                });
        }
    }
</script>
