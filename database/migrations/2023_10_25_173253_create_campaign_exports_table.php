<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaign_exports', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->integer('size');
            $table->tinyInteger('type');
            $table->tinyInteger('status');
            $table->string('path')->nullable();
            $table->timestamps();

            $table->index(['status']);

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_exports');
    }
};
