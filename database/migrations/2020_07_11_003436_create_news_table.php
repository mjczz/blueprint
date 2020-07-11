<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 40)->default('')->comment('标题');
            $table->longText('content')->nullable()->comment('内容');
            $table->unsignedTinyInteger('publish_status')->default('2')->comment('状态1已发布2未发布');
            $table->unsignedTinyInteger('news_top')->default('2')->comment('状态1置顶2非置顶');
            $table->unsignedTinyInteger('news_recommend')->default('2')->comment('状态1推荐2非推荐');
            $table->unsignedTinyInteger('news_type')->default('2')->comment('属性1文字新闻2图片新闻');
            $table->unsignedTinyInteger('sort')->default('100')->comment('排序越小越在前');
            $table->timestamp('published_at')->nullable()->comment('发布时间');
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
        Schema::dropIfExists('news');
    }
}
