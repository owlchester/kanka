<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = ['abilities', 'entities'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $tablename) {
            Schema::table($tablename, function (Blueprint $table) {
                $table->index('deleted_at');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $tablename) {
            Schema::table($tablename, function (Blueprint $table) {
                $table->dropIndex('deleted_at');
            });
        }
    }
};
