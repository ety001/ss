<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_service', function (Blueprint $table) {
            $table->bigIncrements('service_id')->unsigned();
            $table->string('service_name')->comment('套餐名');
            $table->tinyInteger('service_type')->unsigned()->default(1)->comment('服务类型，1按流量(M)，2按时长(天)');
            $table->integer('service_val')->unsigned()->comment('服务值(流量或者天数)');
            $table->tinyInteger('service_status')->unsigned()->default(1)->comment('服务状态，1可用，2不可用');
            $table->decimal('service_money', 8, 2)->default(0)->comment('服务费用');
        });

        Schema::create('ss_port_pool', function (Blueprint $table) {
            $table->integer('port')->unsigned();
            $table->tinyInteger('status')->unsigned()->default(0)->comment('0未使用');
        });

        Schema::create('ss_user', function (Blueprint $table) {
            $table->bigIncrements('user_id')->unsigned();
            $table->string('username');
            $table->string('password');
            $table->tinyInteger('user_type')->unsigned()->default(1)->comment('用户类型，1普通，2vip');
            $table->string('email')->unique();
            $table->tinyInteger('email_chk')->unsigned()->default(0);
            $table->integer('create_time');
            $table->integer('ssport');
            $table->string('sspass');
            $table->decimal('money_amount', 8, 2)->default(0)->comment('余额');
            $table->bigInteger('service_id')->unsigned()->index()->nullable()->comment('购买的服务id');
            $table->rememberToken();

            $table->foreign('service_id')->references('service_id')->on('ss_service')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('ss_regin_key', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('regin_key', 20);
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('user_id')->index()->nullable()->unsigned();
            $table->integer('usetime')->nullable();

            $table->foreign('user_id')->references('user_id')->on('ss_user')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('ss_order', function (Blueprint $table) {
            $table->bigIncrements('order_id')->unsigned();
            $table->string('order_code', 50)->comment('订单号');
            $table->string('trade_no', 50)->comment('支付宝交易流水号');
            $table->bigInteger('user_id')->index()->unsigned();
            $table->decimal('order_money', 8, 2);
            $table->integer('order_time');
            $table->string('order_status', 32)->comment('订单状态,WAIT_BUYER_PAY, WAIT_SELLER_SEND_GOODS, WAIT_BUYER_CONFIRM_GOODS, TRADE_FINISHED, TRADE_CLOSED');

            $table->foreign('user_id')->references('user_id')->on('ss_user')->onDelete('restrict')->onUpdate('restrict');
        });

        Schema::create('ss_invite', function (Blueprint $table) {
            $table->bigIncrements('invite_id')->unsigned();
            $table->bigInteger('user_id')->index()->nullable()->unsigned();
            $table->bigInteger('invited_user_id')->index()->nullable()->unsigned();
            $table->integer('invite_time');
            $table->decimal('has_pay', 8, 2);

            $table->foreign('user_id')->references('user_id')->on('ss_user')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('invited_user_id')->references('user_id')->on('ss_user')->onDelete('set null')->onUpdate('cascade');
        });

        Schema::create('ss_buyservice', function (Blueprint $table) {
            $table->bigIncrements('buyservice_id')->unsigned();
            $table->bigInteger('service_id')->unsigned()->nullable()->index();
            $table->bigInteger('user_id')->index()->unsigned()->nullable();
            $table->integer('buy_time')->comment('购买时间');
            $table->integer('end_time')->comment('服务结束时间');
            $table->tinyInteger('status')->comment('购买状态，1购买成功，2购买失败');

            $table->foreign('service_id')->references('service_id')->on('ss_service')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('user_id')->references('user_id')->on('ss_user')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ss_buyservice', function (Blueprint $table) {
            $table->dropForeign('ss_buyservice_service_id_foreign');
            $table->dropForeign('ss_buyservice_user_id_foreign');
        });
        Schema::drop('ss_buyservice');

        Schema::table('ss_invite', function (Blueprint $table) {
            $table->dropForeign('ss_invite_user_id_foreign');
            $table->dropForeign('ss_invite_invited_user_id_foreign');
        });
        Schema::drop('ss_invite');

        Schema::table('ss_order', function (Blueprint $table) {
            $table->dropForeign('ss_order_user_id_foreign');
        });
        Schema::drop('ss_order');

        Schema::table('ss_regin_key', function (Blueprint $table) {
            $table->dropForeign('ss_regin_key_user_id_foreign');
        });
        Schema::drop('ss_regin_key');

        Schema::table('ss_user', function (Blueprint $table) {
            $table->dropForeign('ss_user_service_id_foreign');
        });
        Schema::drop('ss_user');

        Schema::drop('ss_port_pool');
        Schema::drop('ss_service');
    }
}
