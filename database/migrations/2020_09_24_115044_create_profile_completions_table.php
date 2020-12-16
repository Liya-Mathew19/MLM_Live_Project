<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileCompletionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_completions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_user_id')->nullable();
            $table->foreign('fk_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('percentage')->nullable();
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
        Schema::dropIfExists('profile_completions');
    }
}
