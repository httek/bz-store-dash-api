<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->char('name', 120)->nullable();
            $table->string('image', 400)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamp('visible_begin')->nullable();
            $table->timestamp('visible_ending')->nullable();
            $table->json('meta')->nullable();
            $table->unsignedTinyInteger('position')->default(0);
            $table->integer('sequence')->nullable();
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
        Schema::dropIfExists('blocks');
    }
}
