<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interaction_logs', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('player_session_id');
            $table->unsignedInteger('entity_id');
            $table->unsignedBigInteger('entity_claim_id');
            $table->unsignedInteger('created_by');
            $table->text('note');
            $table->string('visibility', 16)->nullable();
            $table->timestamps();

            $table->foreign('player_session_id')
                ->references('id')->on('player_sessions')->cascadeOnDelete();
            $table->foreign('entity_id')
                ->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('entity_claim_id')
                ->references('id')->on('entity_claims')->cascadeOnDelete();
            $table->foreign('created_by')
                ->references('id')->on('users')->cascadeOnDelete();

            $table->index(['player_session_id', 'created_at']);
            $table->index(['entity_claim_id', 'entity_id']);
            $table->index(['entity_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interaction_logs');
    }
};
