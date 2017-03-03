<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTokenFiled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ss_user', function (Blueprint $table) {
            $table->string('api_token', 60)->nullable()->unique()->after('remember_token');
            $table->integer('expired_time')->nullable()->after('api_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ss_user', function (Blueprint $table) {
            $table->dropColumn('api_token');
            $table->dropColumn('expired_time');
        });
    }
}
