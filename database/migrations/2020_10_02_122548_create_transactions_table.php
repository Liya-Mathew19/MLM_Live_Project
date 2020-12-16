<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('transaction_id');
            $table->unsignedBigInteger('fk_user_id')->nullable();
            $table->foreign('fk_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('subscription_fee')->nullable();
            $table->string('gst')->nullable();
            $table->string('amount')->nullable();
            $table->string('date')->nullable();
            $table->string('paid_from')->nullable();
            $table->string('reference_no')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
