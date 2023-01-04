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
            $table->unsignedTinyInteger('type')->default(0)->comment('0 goods 1 brands');
            $table->char('name', 80)->nullable()->index();
            $table->string('cover', 400)->nullable();
            $table->tinyInteger('level')->default(1);
            $table->unsignedTinyInteger('status')->default(true);
            $table->json('path')->nullable();
            $table->unsignedInteger('sequence')->default(0);
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedBigInteger('created_by')->nullable()->index();
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
        Schema::dropIfExists('categories');
    }
}
