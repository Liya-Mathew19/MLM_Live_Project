<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_acct_id')->nullable();
            $table->foreign('fk_acct_id')->references('acct_id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('subscription_fee')->nullable();
            $table->string('gst')->nullable();
            $table->string('amount')->nullable();
            $table->string('paid_date')->nullable();
            $table->unsignedBigInteger('fk_transaction_id')->nullable();
            $table->foreign('fk_transaction_id')->references('transaction_id')->on('transactions')->onDelete('cascade');
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('status')->nullable();
            $table->string('commission_amount')->nullable();
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
        Schema::dropIfExists('subscription_payments');
    }
}
