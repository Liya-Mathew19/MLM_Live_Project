<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_requests', function (Blueprint $table) {
            $table->bigIncrements('request_id');
            $table->unsignedBigInteger('fk_user_id')->nullable();
            $table->foreign('fk_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('amount')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('commission_requests');
    }
}
