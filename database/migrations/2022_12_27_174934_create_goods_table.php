<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id')->nullable()->index();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->unsignedBigInteger('store_id')->nullable()->index();
            $table->unsignedBigInteger('brand_id')->nullable()->index();
            $table->unsignedBigInteger('category_id')->nullable()->index()->comment('二级分类');
            $table->unsignedTinyInteger('delivery_id')->nullable()->comment('配送模版ID');
            $table->char('uuid', 80)->nullable()->comment('商品编号');
            $table->char('name', 80)->nullable();
            $table->char('slogan', 120)->nullable();
            $table->string('tips', 400)->nullable()->comment('提示');
            $table->integer('sale_price')->default(0);
            $table->integer('origin_price')->default(0);
            $table->json('tags')->nullable()->comment('标签');
            $table->json('covers')->nullable()->comment('图片');
            $table->json('detail')->nullable()->comment('详情图片');
            $table->string('material', 120)->nullable()->comment('原料');
            $table->string('description', 400)->nullable()->comment('商品描述');
            $table->unsignedBigInteger('stock')->nullable()->comment('库存');
            $table->unsignedBigInteger('sold')->nullable()->comment('已售');
            $table->unsignedTinyInteger('status')->default(1)->comment('0 待审 1 下架 2 上架');
            $table->unsignedTinyInteger('free_shipping')->default(0)->comment('是否包邮');
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
        Schema::dropIfExists('goods');
    }
}
