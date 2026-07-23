<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maps', function (Blueprint $table): void {
            $table->timestamp('tiling_prompt_dismissed_at')->nullable();
            $table->dropColumn('chunking_status');
        });
    }

    public function down(): void
    {
        Schema::table('maps', function (Blueprint $table): void {
            $table->dropColumn('tiling_prompt_dismissed_at');
            $table->unsignedTinyInteger('chunking_status')->nullable();
        });
    }
};
