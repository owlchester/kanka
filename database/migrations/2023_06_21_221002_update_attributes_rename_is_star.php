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
        if (Schema::hasColumn('attributes', 'is_pinned')) {
            return;
        }
        Schema::table('attributes', function (Blueprint $table) {
            $table->renameColumn('is_star', 'is_pinned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->renameColumn('is_pinned', 'is_star');
        });
    }
};
