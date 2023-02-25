<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNavsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('navs', function (Blueprint $table) {
            $table->id();
            $table->char('title')->nullable();
            $table->string('image', 400)->nullable();
            $table->unsignedTinyInteger('target')->default(0)
                ->comment('0 一级分类 1 二级分类 2 标签下商品 4 小程序页面 5 Web View');
            $table->string('subject')->nullable();
            $table->tinyInteger('style')->default(0)
                ->comment('0 默认， 1 1/2 图片');
            $table->unsignedTinyInteger('position')->default(0);
            $table->integer('sequence')->default(0);
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
        Schema::dropIfExists('navs');
    }
}
