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
            $table->unsignedTinyInteger('type')->default(0)->comment('0 goods');
            $table->char('name', 80)->nullable();
            $table->string('cover', 400)->nullable();
            $table->unsignedTinyInteger('status')->default(true);
            $table->unsignedInteger('sequence')->nullable();
            $table->unsignedBigInteger('parent')->nullable();
            $table->tinyInteger('level')->default(1);
            $table->timestamps();

            $table->foreign('parent')->references('id')->on('categories');
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
