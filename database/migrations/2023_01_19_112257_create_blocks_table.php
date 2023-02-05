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
            $table->string('cover', 400)->nullable();
            $table->unsignedTinyInteger('position')->default(0);
            $table->integer('sequence')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->json('meta')->nullable();
            $table->timestamp('deadline_at')->nullable();
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
