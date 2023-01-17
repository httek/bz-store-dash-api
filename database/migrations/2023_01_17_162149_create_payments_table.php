<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type')->default(0);
            $table->unsignedTinyInteger('version')->default(1)->comment('0 v2, 1 v3');
            $table->char('name', 80)->nullable();
            $table->char('merchant_id', 80)->nullable()->index();
            $table->char('merchant_name', 80)->nullable();
            $table->string('secret', 400)->nullable();
            $table->string('serial', 100)->nullable()->index();
            $table->text('public_key')->nullable();
            $table->text('private_key')->nullable();
            $table->text('platform_public_key')->nullable();
            $table->char('platform_key_serial', 100)->nullable()->index();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
