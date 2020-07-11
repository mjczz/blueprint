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
            $table->unsignedTinyInteger('publish_status')->default('0')->comment('状态1已发布0未发布');
            $table->unsignedTinyInteger('news_top')->default('0')->comment('状态1置顶0非置顶');
            $table->unsignedTinyInteger('news_recommend')->default('0')->comment('状态1推荐0非推荐');
            $table->unsignedTinyInteger('news_type')->default('0')->comment('属性0文字新闻1图片新闻');
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
