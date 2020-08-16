<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHotUserOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_user_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('publish_order_id')->default('0')->comment('发布订单id');
            $table->string('order_no', 100)->default('')->comment('订单编号');
            $table->unsignedTinyInteger('order_type')->default('1')->comment('订单类型1买入订单2卖出订单');
            $table->unsignedTinyInteger('order_status')->default('1')->comment('订单状态1已锁单2已取消3已付款4已完成5已关闭');
            $table->unsignedTinyInteger('order_amount_type')->default('1')->comment('发布订单额度类型1小额交易2中等交易3大额交易');
            $table->unsignedInteger('nums')->default('0')->comment('收购数或出售数');
            $table->decimal('price', 10, 2)->default('0')->comment('收购价或出售价');
            $table->decimal('amount', 10, 2)->default('0')->comment('总价');
            $table->unsignedInteger('hot_user_id')->default('0')->comment('锁定人');
            $table->timestamp('lock_time')->nullable()->comment('锁单时间');
            $table->timestamp('pay_time')->nullable()->comment('付款时间');
            $table->timestamp('confirm_time')->nullable()->comment('确认时间');
            $table->longText('pay_attach')->nullable()->comment('打款凭证');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `hot_user_orders` COMMENT '用户订单表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hot_user_orders');
    }
}
