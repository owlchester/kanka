<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('maps', function (Blueprint $table): void {
            $table->unsignedTinyInteger('chunking_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maps', function (Blueprint $table): void {
            $table->dropColumn('chunking_status');
        });
    }
};
