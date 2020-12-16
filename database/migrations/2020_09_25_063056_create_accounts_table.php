<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('acct_id');
            $table->unsignedBigInteger('fk_user_id')->nullable();
            $table->foreign('fk_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('fk_referral_id')->nullable();
            $table->string('fk_parent_id')->nullable();
            $table->string('position')->nullable();
            $table->string('acct_type')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
