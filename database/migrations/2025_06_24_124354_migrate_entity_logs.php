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
        DB::statement("UPDATE entity_logs SET parent_type = 'App\\\Models\\\Entity', parent_id = entity_id WHERE post_id IS NULL");
        DB::statement("UPDATE entity_logs SET parent_type = 'App\\\Models\\\Post', parent_id = post_id WHERE post_id IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entity_logs', function (Blueprint $table) {
            //
        });
    }
};
