<template>
    <div class="row marketing">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-sm-3">
                    <a href="http://weidian.com/item.html?itemID=1699892062" target="_blank" class="pay-btn btn btn-lg btn-primary">充 10 RMB</a>
                </div>
                <div class="col-sm-3">
                    <a href="http://weidian.com/item.html?itemID=1699892062" target="_blank" class="pay-btn btn btn-lg btn-success">充 20 RMB</a>
                </div>
                <div class="col-sm-3">
                    <a href="http://weidian.com/item.html?itemID=1699892062" target="_blank" class="pay-btn btn btn-lg btn-info">充 50 RMB</a>
                </div>
                <div class="col-sm-3">
                    <a href="http://weidian.com/item.html?itemID=1699892062" target="_blank" class="pay-btn btn btn-lg btn-danger">充 100 RMB</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        支付流程（请严格按照下面的步骤进行）：<br>
                        1、点击上方按钮，跳转到『微店』，选择对应的产品进行支付，支付完成进入下一步，（支付方式如果选择直接到账，请直接跳到第五步）<br>
                        2、在下面的输入框中输入上一步在『微店』的订单号，点击提交，<br>
                        3、如果已经支付，那么会显示『已经确认收货』按钮，前去『微店』确认收货后，点击『已经确认收货』即可完成充值。<br>
                        4、如果未支付，那么会显示『已经支付』按钮，请前去『微店』完成支付后，点击『已经支付』按钮，再执行第三步操作。<br>
                        5、如果在『微店』选择的是直接到账，则在下面的输入框输入『微店』的订单号，点击提交后，点击『已经确认收货』按钮即可完成充值。<br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form class="form" action="/user-addorder.html" method="post">
                        <label for="order_id">请输入微店的订单号</label>
                        <input id="order_id" type="text" class="form-control" name="order_id" value=""><br>
                        <input type="submit" class="form-control pay-btn btn btn-success" value="提交"><br>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert">
                        当前余额：<code>71314</code> RMB
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>订单号</th>
                                <th>金额</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>774240727810772</td>
                                <td>20</td>
                                <td>订单完成</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>774240729907924</td>
                                <td>10</td>
                                <td>订单完成</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>774303239045844</td>
                                <td>10</td>
                                <td>订单完成</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>774538837181140</td>
                                <td>10</td>
                                <td>订单完成</td>
                                <td></td>
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
.pay-btn {
    width: 100%;
    margin-bottom: 20px;
}
</style>
<script>
    import alertComponent from './common/alert.vue';

    export default {
        data() {
            return {
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
        }
    }
</script>
