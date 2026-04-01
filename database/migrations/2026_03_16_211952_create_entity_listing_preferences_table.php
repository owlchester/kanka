<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entity_listing_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('type_id');
            $table->json('visible_columns')->nullable();
            $table->string('layout', 10)->nullable();
            $table->boolean('nested')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'campaign_id', 'type_id'], 'listing_pref_unique');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('type_id')->references('id')->on('entity_types')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entity_listing_preferences');
    }
};
