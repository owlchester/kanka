<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $tableNames = ['entities', 'posts', 'timeline_elements', 'timeline_eras', 'character_traits', 'quest_elements', 'map_layers', 'map_markers'];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tableNames as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedInteger('words')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tableNames as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('words');
            });
        }
    }
};
