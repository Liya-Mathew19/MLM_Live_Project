<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWalletIdToCommissionPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commission_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('fk_wallet_id')->nullable();
            $table->foreign('fk_wallet_id')->references('id')->on('wallet_transactions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commission_payments', function (Blueprint $table) {
            //
        });
    }
}
