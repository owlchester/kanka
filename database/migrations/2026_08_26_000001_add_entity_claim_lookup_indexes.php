<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entity_claims', function (Blueprint $table): void {
            $table->index(['user_id', 'unclaimed_at', 'entity_id']);
            $table->index(['entity_id', 'unclaimed_at']);
        });
    }

    public function down(): void
    {
        Schema::table('entity_claims', function (Blueprint $table): void {
            $table->dropIndex(['user_id', 'unclaimed_at', 'entity_id']);
            $table->dropIndex(['entity_id', 'unclaimed_at']);
        });
    }
};
