<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('interaction_logs', function (Blueprint $table): void {
            $table->string('attitude', 16)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('interaction_logs', function (Blueprint $table): void {
            $table->dropColumn('attitude');
        });
    }
};
