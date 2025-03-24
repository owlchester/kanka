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
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->unsignedInteger('entity_type_id')->nullable();
            $table->foreign('entity_type_id')->references('id')->on('entity_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropForeign('bookmarks_entity_type_id_foreign');
            $table->dropColumn('entity_type_id');
        });
    }
};
