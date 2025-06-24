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
        Schema::table('entity_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id');
            $table->string('parent_type');
            $table->index(['parent_id', 'parent_type']);
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entity_logs', function (Blueprint $table) {
            $table->dropIndex(['parent_id', 'parent_type']);
            $table->dropColumn('parent_type');
            $table->dropColumn('parent_id');
        });
    }
};
