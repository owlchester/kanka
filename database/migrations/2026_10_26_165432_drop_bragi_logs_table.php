<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('bragi_logs');
    }

    public function down(): void
    {
        // This recreates the schema only; dropped historical logs cannot be restored.
        Schema::create('bragi_logs', function (Blueprint $table): void {
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
};
