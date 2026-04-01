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
        Schema::table('quest_elements', function (Blueprint $table) {
            $table->boolean('copy_entity_entry')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quest_elements', function (Blueprint $table) {
            $table->dropColumn('copy_entity_entry');
        });
    }
};
