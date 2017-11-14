<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned()->notNull();
            $table->integer('created_by')->unsigned()->nullable();
            $table->string('token', 128);
            $table->string('email', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->index(['token', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_invites');
    }
}
