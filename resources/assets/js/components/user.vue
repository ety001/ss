<template>
    <div class="row marketing">
        <div class="col-md-8 col-md-offset-2">

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
