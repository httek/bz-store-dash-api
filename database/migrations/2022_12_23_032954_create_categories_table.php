<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type')->default(0)->comment('0 产品分类 1 品牌分类');
            $table->char('name', 80)->nullable();
            $table->string('cover', 400)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('sequence')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->tinyInteger('level')->default(1);
            $table->json('path')->nullable()->comment('路径 ...[1, 2, 3]');
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
