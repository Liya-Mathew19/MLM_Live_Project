<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGstToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('cgst_rate')->nullable()->after('subscription_fee');
            $table->string('cgst_amount')->nullable()->after('cgst_rate');
            $table->string('sgst_rate')->nullable()->after('cgst_amount');
            $table->string('sgst_amount')->nullable()->after('sgst_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
