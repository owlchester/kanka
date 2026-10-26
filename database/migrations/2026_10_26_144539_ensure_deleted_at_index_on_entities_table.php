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
        Schema::whenTableDoesntHaveIndex('entities', ['deleted_at'], function (Blueprint $table) {
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasIndex('entities', 'entities_deleted_at_index')) {
            Schema::table('entities', function (Blueprint $table) {
                $table->dropIndex('entities_deleted_at_index');
            });
        }
    }
};
