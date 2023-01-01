<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable()->index()->comment('一级分类');
            $table->char('uuid', 80)->nullable()->unique();
            $table->char('name', 120)->nullable();
            $table->json('images')->nullable()->comment('产品图片');
            $table->string('description', 400)->nullable()->comment('产品描述');
            $table->unsignedTinyInteger('status')->default(1)->comment('0 待审 0 下架 1 上架');
            $table->unsignedBigInteger('sequence')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
