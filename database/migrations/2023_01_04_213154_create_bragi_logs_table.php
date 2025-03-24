<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bragi_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('campaign_id')->nullable();
            $table->text('prompt');
            $table->text('result')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table->index(['created_at']);
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bragi_logs');
    }
};
