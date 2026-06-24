<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex('idx_card_expires_at');
            $table->dropColumn('card_expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dateTime('card_expires_at')->nullable();
            $table->index(['card_expires_at'], 'idx_card_expires_at');
        });
    }
};
