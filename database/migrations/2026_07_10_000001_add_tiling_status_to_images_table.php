<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table): void {
            $table->unsignedTinyInteger('tiling_status')->nullable();
            $table->text('tiling_error')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table): void {
            $table->dropColumn(['tiling_status', 'tiling_error']);
        });
    }
};
