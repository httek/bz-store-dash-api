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
            $table->unsignedBigInteger('owner_id')->nullable()->index();
            $table->unsignedBigInteger('store_id')->nullable()->index();
            $table->unsignedBigInteger('brand_id')->nullable()->index();
            $table->unsignedBigInteger('category_id')->nullable()->index()->comment('一级分类');
            $table->unsignedTinyInteger('delivery_template_id')->nullable()->comment('配送模版ID');
            $table->char('name', 120)->nullable();
            $table->json('images')->nullable()->comment('商品图片');
            $table->string('description', 400)->nullable()->comment('商品描述');
            $table->unsignedTinyInteger('status')->default(1)->comment('0 待审 1 下架 2 上架');
            $table->unsignedTinyInteger('delivery_free')->default(0)->comment('是否包邮');
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
