<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHotBeanExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_bean_exchanges', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('hot_user_id')->default('0')->comment('用户id');
            $table->unsignedTinyInteger('exchange_type')->default('1')->comment('兑换类型1HOT兑换红豆2红豆兑换HOT');
            $table->unsignedInteger('from_nums')->default('0')->comment('兑换数量');
            $table->unsignedInteger('to_nums')->default('0')->comment('获得数量');
            $table->decimal('service_charge', 10, 2)->default('0')->comment('手续费');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `hot_bean_exchanges` COMMENT 'hot红豆兑换记录表'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hot_bean_exchanges');
    }
}
