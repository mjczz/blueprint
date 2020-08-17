<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 40)->default('')->comment('标题');
            $table->longText('desc')->nullable()->comment('描述');
            $table->unsignedTinyInteger('publish_status')->default('2')->comment('状态1已发布2未发布');
            $table->unsignedTinyInteger('movie_top')->default('2')->comment('状态1置顶2非置顶');
            $table->unsignedTinyInteger('movie_recommend')->default('2')->comment('状态1推荐2非推荐');
            $table->unsignedTinyInteger('movie_hot')->default('2')->comment('状态1热搜2非热搜');
            $table->unsignedInteger('sort')->default('100')->comment('排序越小越在前');
            $table->timestamp('published_at')->nullable()->comment('上映时间');
            $table->unsignedInteger('view_num')->default('0')->comment('观看人数');
            $table->decimal('score', 4, 1)->default('0')->comment('评分');
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
        Schema::dropIfExists('movies');
    }
}
