<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_details', function (Blueprint $table) {
            $table->bigIncrements('income_id');
            $table->unsignedBigInteger('fk_acct_id')->nullable();
            $table->foreign('fk_acct_id')->references('acct_id')->on('accounts')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('fk_wallet_id')->nullable();
            $table->foreign('fk_wallet_id')->references('id')->on('wallet_transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('no_of_active_node')->nullable();
            $table->string('amount')->nullable();
            $table->string('date')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('income_details');
    }
}
