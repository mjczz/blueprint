<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHotPayAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_pay_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('account_type')->default('1')->comment('账号类型1支付宝2银行卡');
            $table->string('account', 30)->default('')->comment('账号');
            $table->string('account_name', 30)->default('')->comment('银行名称');
            $table->unsignedInteger('hot_user_id')->default('0')->comment('用户id');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `hot_pay_accounts` COMMENT '用户支付账号表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hot_pay_accounts');
    }
}
