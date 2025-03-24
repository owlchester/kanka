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
        Schema::table('creatures', function (Blueprint $table) {
            $table->boolean('is_dead')->default(0);
            $table->index('is_dead');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creatures', function (Blueprint $table) {
            $table->dropIndex('is_dead');
            $table->dropColumn('is_dead');
        });
    }
};
