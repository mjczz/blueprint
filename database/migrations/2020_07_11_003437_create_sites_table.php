<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('title', 40)->default('')->comment('网站Title');
            $table->string('keywords', 255)->default('')->comment('网站Keywords');
            $table->longText('desc')->nullable()->comment('网站description');
            $table->string('copyright', 100)->default('')->comment('版权信息');
            $table->string('icp', 100)->default('')->comment('网站ICP备案序号');
            $table->longText('external_traffic')->nullable()->comment('外嵌流量统计代码');
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
        Schema::dropIfExists('sites');
    }
}
