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
        Schema::table('entity_notes', function (Blueprint $table) {
            $table->unsignedInteger('layout_id')->nullable();

            $table->foreign('layout_id')->references('id')->on('post_layouts')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entity_notes', function (Blueprint $table) {
            $table->dropColumn('layout_id');
        });
    }
};
