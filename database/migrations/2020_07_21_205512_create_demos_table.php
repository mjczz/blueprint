<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demos', function (Blueprint $table) {
            $table->id();
            $table->string('title', 40)->default('')->comment('标题');
            $table->unsignedInteger('user_id')->default('0')->comment('用户id');
            $table->longText('desc')->nullable()->comment('描述');
            $table->unsignedTinyInteger('publish_status')->default('2')->comment('发布状态1已发布2未发布');
            $table->unsignedTinyInteger('demo_top')->default('2')->comment('置顶状态1置顶2非置顶');
            $table->unsignedTinyInteger('demo_recommend')->default('2')->comment('推荐状态1推荐2非推荐');
            $table->unsignedInteger('sort')->default('100')->comment('排序越小越在前');
            $table->timestamp('published_at')->nullable()->comment('发布时间');
            $table->decimal('demo_score', 4, 1)->default('0')->comment('评分');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demos');
    }
}
