<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('country_code');
            $table->string('phone')->unique();
            $table->text('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('confirm_password');
            $table->string('secondary_password')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('acct_no')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('income')->nullable();
            $table->string('phone_otp')->nullable();
            $table->string('email_otp')->nullable();
            $table->string('phone_status')->nullable();
            $table->string('email_status')->nullable();
            $table->string('user_status')->nullable();
            $table->string('user_type')->nullable();
            $table->string('approval_status_notification')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
