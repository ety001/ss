<template>
    <div class="row marketing">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="success">
                                <td width="50%">
                                    余额：
                                    <code>{{ money_amount }}</code> RMB
                                    <router-link to="/pay">充值</router-link>
                                </td>
                                <td width="50%">
                                    服务状态：
                                    已开通服务 <code>D360型套餐</code>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="warning">
                                <td>D1型套餐</td>
                                <td>1 天</td>
                                <td>1 RMB</td>
                                <td><a href="/user-buysave-service_id-1.html" onclick="if(!confirm('是否要购买 D1型套餐？注意：购买后无法退款。'))return false;">购买并开通服务</a></td>
                            </tr>
                            <tr class="warning">
                                <td>D7型套餐</td>
                                <td>7 天</td>
                                <td>3 RMB</td>
                                <td><a href="/user-buysave-service_id-2.html" onclick="if(!confirm('是否要购买 D7型套餐？注意：购买后无法退款。'))return false;">购买并开通服务</a></td>
                            </tr>
                            <tr class="warning">
                                <td>D30型套餐</td>
                                <td>30 天</td>
                                <td>10 RMB</td>
                                <td><a href="/user-buysave-service_id-3.html" onclick="if(!confirm('是否要购买 D30型套餐？注意：购买后无法退款。'))return false;">购买并开通服务</a></td>
                            </tr>
                            <tr class="warning">
                                <td>D90型套餐</td>
                                <td>90 天</td>
                                <td>30 RMB</td>
                                <td><a href="/user-buysave-service_id-4.html" onclick="if(!confirm('是否要购买 D90型套餐？注意：购买后无法退款。'))return false;">购买并开通服务</a></td>
                            </tr>
                            <tr class="warning">
                                <td>D360型套餐</td>
                                <td>360 天</td>
                                <td>60 RMB</td>
                                <td><a href="/user-buysave-service_id-5.html" onclick="if(!confirm('是否要购买 D360型套餐？注意：购买后无法退款。'))return false;">购买并开通服务</a></td>
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
                money_amount : null,
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
                    //console.log(res);
                    switch (res.status) {
                        case 200:
                            let data = res.data;
                            switch (data.status) {
                                case true:
                                    that.money_amount = data.data.money_amount;
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
