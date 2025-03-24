<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('campaign_id')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->string('token', 128);
            $table->boolean('is_active')->default(true);

            $table->integer('validity')->unsigned()->nullable();
            // $table->integer('role_id')->unsigned()->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            // $table->foreign('role_id')->references('id')->on('campaign_roles')->onDelete('set null');

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
