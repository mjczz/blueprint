<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 40)->default('');
            $table->longText('content')->nullable();
            $table->unsignedTinyInteger('publish_status')->default('2');
            $table->unsignedTinyInteger('news_top')->default('2');
            $table->unsignedTinyInteger('news_recommend')->default('2');
            $table->unsignedTinyInteger('news_type')->default('1');
            $table->unsignedTinyInteger('sort')->default('100');
            $table->timestamp('published_at')->nullable();
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
        Schema::dropIfExists('blogs');
    }
}
