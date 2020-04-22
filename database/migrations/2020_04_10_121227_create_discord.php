<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app', 20);
            $table->integer('user_id')->unsigned();
            $table->string('access_token');
            $table->string('refresh_token');
            $table->dateTime('expires_at');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_apps');
    }
}
