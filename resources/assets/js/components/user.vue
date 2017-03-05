<template>
    <div class="row marketing">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="success">
                                <td>用户登录名</td>
                                <td>ety001</td>
                            </tr>
                            <tr class="success">
                                <td>用户类型</td>
                                <td>VIP</td>
                            </tr>
                            <tr class="success">
                                <td>用户余额</td>
                                <td>
                                    <code>71314</code> RMB
                                    <a href="/user-order.html">充值</a>
                                </td>
                            </tr>
                            <tr class="warning">
                                <td>服务状态</td>
                                <td>
                                    已开通服务 <code>D360型套餐</code>
                                </td>
                            </tr>
                            <tr class="warning">
                                <td>服务开始时间</td>
                                <td>
                                    2017-01-07 10:01:15
                                </td>
                            </tr>
                            <tr class="warning">
                                <td>服务到期时间</td>
                                <td>
                                    2018-01-02 10:01:15
                                </td>
                            </tr>
                            <tr class="warning">
                                <td>服务运行状态</td>
                                <td><code>正在运行</code></td>
                            </tr>
                            <tr class="info">
                                <td>Shadowsocks 服务器地址</td>
                                <td><code>gfw1.fuckspam.in</code></td>
                            </tr>
                            <tr class="info">
                                <td>Shadowsocks 服务器端口</td>
                                <td><code>10000</code></td>
                            </tr>
                            <tr class="info">
                                <td>Shadowsocks 服务器密码</td>
                                <td><code>woqimm</code></td>
                            </tr>
                            <tr class="info">
                                <td>Shadowsocks 服务器加密方式</td>
                                <td><code>aes-256-cfb</code></td>
                            </tr>
                        </tbody>
                    </table>
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
                money_amount : null,
                service : null,
                alertDisplay: false,
                alertMsg: '',
                alertStatus: ''
            }
        },
        components: {
            'alert-component': alertComponent
        },
        methods: {
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
                    console.log(res);
                    switch (res.status) {
                        case 200:
                            let data = res.data;
                            switch (data.status) {
                                case true:

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
