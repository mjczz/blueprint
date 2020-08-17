<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHotComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_complains', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('hot_user_id')->default('0')->comment('申诉人');
            $table->unsignedInteger('order_id')->default('0')->comment('用户订单id');
            $table->unsignedTinyInteger('complain_type')->default('1')->comment('申诉类型1已付款未交易2未收到款货3其他原因');
            $table->unsignedTinyInteger('complain_status')->default('1')->comment('申诉状态1处理中2已完成');
            $table->longText('content')->nullable()->comment('申诉内容');
            $table->longText('content_pic')->nullable()->comment('已付款未交易类型可添加图片');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `hot_complains` COMMENT '用户订单投诉表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hot_complains');
    }
}
