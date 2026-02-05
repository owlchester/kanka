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
        Schema::create('spotlight_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->json('content_json')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spotlight_survey');
    }
};
