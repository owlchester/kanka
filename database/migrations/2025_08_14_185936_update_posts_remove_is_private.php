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
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasIndex('posts', 'entity_notes_name_is_private_index')) {
                $table->dropIndex('entity_notes_name_is_private_index');
            }
            if (Schema::hasColumn('posts', 'is_private')) {
                $table->dropColumn('is_private');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_private')->default(0);
        });
    }
};
