<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHotUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hot_users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100)->default('')->comment('用户姓名');
            $table->string('mobile', 20)->default('')->comment('手机号');
            $table->unsignedInteger('app_user_id')->default('0')->comment('对应的app端用户id');
            $table->unsignedInteger('red_bean_nums')->default('0')->comment('红豆数量');
            $table->unsignedInteger('hot_bean_nums')->default('0')->comment('hot数量');
            $table->unsignedInteger('frozen_hot_bean_nums')->default('0')->comment('冻结hot数量');
            $table->unsignedTinyInteger('hot_user_status')->default('1')->comment('用户状态1正常2冻结');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `hot_users` COMMENT '用户表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hot_users');
    }
}
