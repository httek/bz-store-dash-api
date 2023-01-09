<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->char('name', 120)->nullable();
            $table->integer('cost')->default(0)->comment('运费');
            $table->unsignedTinyInteger('type')->default(0)->comment('配送方式: 0 快递物流 1 商家配送 2 其他');
            $table->json('meta')->nullable()->comment('配送信息');
            $table->string('tips', 400)->nullable()->comment('提示');
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedBigInteger('sequence')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable()->index();
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
        Schema::dropIfExists('deliveries');
    }
}
