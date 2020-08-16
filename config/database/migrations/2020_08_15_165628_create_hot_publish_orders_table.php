<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHotPublishOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_publish_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('lock_status')->default('1')->comment('发布订单锁定状态1未锁定2已锁定');
            $table->unsignedTinyInteger('order_type')->default('1')->comment('发布订单类型1买入订单2卖出订单');
            $table->unsignedTinyInteger('order_amount_type')->default('1')->comment('发布订单额度类型1小额交易2中等交易3大额交易');
            $table->unsignedInteger('nums')->default('0')->comment('收购数或出售数');
            $table->decimal('frozen_nums', 10, 2)->default('0')->comment('冻结收购数或冻结出售数');
            $table->decimal('price', 10, 2)->default('0')->comment('收购价或出售价');
            $table->unsignedInteger('hot_user_id')->default('0')->comment('发布人');
            $table->decimal('sales_service_charge', 10, 2)->default('0')->comment('卖出挂单或卖出时的手续费');
            $table->string('secret', 20)->default('')->comment('交易密码');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `hot_publish_orders` COMMENT '用户发布订单表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hot_publish_orders');
    }
}
