<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwipersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swipers', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('position')->default(0);
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('style', 400)->nullable();
            $table->timestamp('visible_begin')->nullable();
            $table->timestamp('visible_ending')->nullable();
            $table->json('items')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('swipers');
    }
}
