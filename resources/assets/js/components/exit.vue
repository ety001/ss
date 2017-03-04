<template>
    <div class="row marketing">
        <div class="col-md-8 col-md-offset-2">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <p class="bg-info">{{ msg }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
p {
    padding: 15px;
    padding-top: 15px;
    padding-right: 15px;
    padding-bottom: 15px;
    padding-left: 15px;
}
</style>
<script>
    export default {
        data() {
            return {
                msg: '正在退出'
            }
        },
        created() {
            let that = this;
            window.msg_point = function () {
                that.msg = that.msg + '.';
            }
            let msg_interval = setInterval("window.msg_point()",500);
            setTimeout(function(){
                that.$cookies.remove('user_token');
                that.$parent.login_status = false;
                window.clearInterval(msg_interval);
                that.$router.push({path:'/'});
            }, 2000);
        }
    }
</script>
