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
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->unsignedTinyInteger('type')->default(1)->comment('0 目录 1 菜单 2 按钮');
            $table->char('title', 80)->nullable();
            $table->string('icon', 400)->nullable();
            $table->string('path', 400)->nullable();
            $table->char('slug', 160)->nullable()->index()->comment('权限标识');
            $table->unsignedTinyInteger('status')->default(1);
            $table->char('component', 160)->nullable();
            $table->json('meta')->nullable();
            $table->integer('sequence')->default(0);
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
