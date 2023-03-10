<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->char('partner', 180)->unique()->comment('商家名称');
            $table->char('name', 80)->unique()->comment('店铺名称');
            $table->string('cover', 400)->nullable()->comment('店铺Logo');
            $table->json('photos')->nullable()->comment('店铺图册');
            $table->unsignedTinyInteger('cash')->default(0)->comment('收款方式:0 对公 1 对私');
            $table->json('cash_meta')->nullable()->comment('收款信息');
            $table->string('address', 200)->nullable()->comment('地区');
            $table->string('aptitude', 400)->nullable()->comment('资质文件');
            $table->integer('deposit')->nullable()->comment('保证金');
            $table->char('phone', 18)->nullable()->comment('服务热线');
            $table->integer('deduct')->nullable()->comment('分成比例');
            $table->unsignedBigInteger('sequence')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable()->comment('店铺账号ID');
            $table->unsignedTinyInteger('status')->default(1)->comment('0 Blocked 1 Closing 2 Sale');
            $table->string('description', 400)->nullable();
            $table->unsignedTinyInteger('level')->default(0);
            $table->timestamp('expired_at')->nullable()->comment('服务截止');
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
        Schema::dropIfExists('stores');
    }
}
