<template>
    <div class="row marketing">
        <div class="col-md-8 col-md-offset-2">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-8 col-md-offset-2">
                    <div>
                        <div class="form-group">
                            <label for="regin">邀请码</label>&nbsp;&nbsp;<a href="javascript:void(0);" data-toggle="modal" data-target="#inviteCode">获取</a>
                            <input id="regin" type="text" class="form-control" v-model="userinfo.regin">
                        </div>
                        <div class="form-group">
                            <label for="username">用户名</label>
                            <input id="username" type="text" class="form-control" v-model="userinfo.username">
                        </div>
                        <div class="form-group">
                            <label for="password">密码</label>
                            <input id="password" type="password" class="form-control" v-model="userinfo.password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">再输入一遍密码</label>
                            <input id="password_confirmation" type="password" class="form-control" v-model="userinfo.password_confirmation">
                        </div>
                        <div class="form-group">
                            <label for="email">邮箱地址</label>
                            <input id="email" type="email" class="form-control" v-model="userinfo.email">
                            <p class="help-block">请正确填写您的邮箱地址，邮箱将用来接收重要通知，<code>且邮箱验证通过后才可开通服务</code>。</p>
                        </div>
                        <div class="form-group">
                            <label for="sspass">Shadowsocks密码</label>
                            <input id="sspass" type="text" class="form-control" v-model="userinfo.sspass">
                            <p class="help-block">设置您的Shadowsocks登陆密码（设置后不可修改）</p>
                        </div>
                        <button class="btn btn-default" @click="register">提交注册</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <transition name="fade">
                        <alert-component :displayTag="alertDisplay" :className="alertStatus">{{ alertMsg }}</alert-component>
                    </transition>
                </div>
            </div>
        </div>
        <div class="modal fade" id="inviteCode" tabindex="-1" role="dialog" aria-labelledby="inviteCode" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">邀请码</h4>
                    </div>
                    <div class="modal-body">
                        <p>由于本站注册即送5元体验金，但是貌似好像很多朋友都来频繁注册套现这5元，所以加入邀请码机制。</p>
                        <p>获取方法很简单，扫二维码关注我的个人公众号，发送<code>ss</code>，等待我的人工审核，然后就能获取到邀请码啦。</p>
                        <p><img src="img/dm.jpg"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
                    regin: '',
                    username: '',
                    password: '',
                    password_confirmation: '',
                    email: '',
                    sspass: ''
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
            register() {
                var that = this;
                this.$http.post('regin', this.userinfo).then(res => {
                    switch (res.status) {
                        case 200:
                            var resBody = res.body;
                                switch (resBody.status) {
                                    case true:

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
            alert(msg, status, timeout) {
                var that = this;
                this.alertDisplay = true;
                this.alertMsg = msg;
                this.alertStatus = status;
                setTimeout(function(){
                    that.alertDisplay = false;
                    that.alertMsg = '';
                    that.alertStatus = '';
                }, timeout ? timeout : 5000);
            }
        }
    }
</script>
