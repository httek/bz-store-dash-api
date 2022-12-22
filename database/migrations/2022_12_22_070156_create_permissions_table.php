<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent')->nullable();
            $table->boolean('type')->default(true)->comment('0 directory 1 menu 2 button');
            $table->char('name', 80)->nullable();
            $table->string('icon', 400)->nullable();
            $table->string('path', 400)->nullable();
            $table->char('title', 80)->nullable();
            $table->boolean('status')->default(true);
            $table->char('component', 160)->nullable();
            $table->json('meta')->nullable();
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
        Schema::dropIfExists('permissions');
    }
}
