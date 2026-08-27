<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('player_sessions', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('entity_claim_id');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('number');
            $table->string('name', 191);
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->text('summary')->nullable();
            $table->timestamps();

            $table->foreign('entity_claim_id')
                ->references('id')->on('entity_claims')->cascadeOnDelete();
            $table->foreign('created_by')
                ->references('id')->on('users')->cascadeOnDelete();

            $table->unique(['entity_claim_id', 'number']);
            $table->index(['entity_claim_id', 'started_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('player_sessions');
    }
};
