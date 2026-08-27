<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('player_sessions', function (Blueprint $table): void {
            $table->softDeletes();
            $table->index('deleted_at');
        });

        Schema::table('interaction_logs', function (Blueprint $table): void {
            $table->softDeletes();
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::table('interaction_logs', function (Blueprint $table): void {
            $table->dropIndex(['deleted_at']);
            $table->dropSoftDeletes();
        });

        Schema::table('player_sessions', function (Blueprint $table): void {
            $table->dropIndex(['deleted_at']);
            $table->dropSoftDeletes();
        });
    }
};
