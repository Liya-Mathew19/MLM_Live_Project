<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_request_id')->nullable();
            $table->foreign('fk_request_id')->references('request_id')->on('commission_requests')->onDelete('cascade')->onUpdate('cascade');
            $table->string('amount')->nullable();
            $table->string('tds_percentage')->nullable();
            $table->string('tds_amount')->nullable();
            $table->string('total')->nullable();
            $table->string('reference_no')->nullable();
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
        Schema::dropIfExists('commission_payments');
    }
}
