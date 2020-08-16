<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHotUserOrdersFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hot_user_orders', function (Blueprint $table) {
            $table->unsignedInteger('seller_user_id')->default('0')->comment('卖方user_id');
            $table->unsignedTinyInteger('order_status_buyer')->default('1')->comment('买方订单状态1已锁单2确认付款3确认收货4已取消');
            $table->unsignedTinyInteger('order_status_seller')->default('1')->comment('卖方订单状态1已锁单2确认收款3释放hot');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
