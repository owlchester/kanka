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
        Schema::dropIfExists('posts');
        Schema::rename('entity_notes', 'posts');
        Schema::rename('entity_note_permissions', 'post_permissions');

        Schema::table('post_permissions', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->renameColumn('entity_note_id', 'post_id');

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('posts', 'entity_notes');
        Schema::rename('post_permissions', 'entity_note_permissions');

        Schema::table('post_permissions', function (Blueprint $table) {
            $table->foreign('post_id')->references('id')->on('entity_notes')->onDelete('cascade');
        });

        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->renameColumn('entity_note_id', 'post_id');

            $table->foreign('entity_note_id')->references('id')->on('entity_notes')->onDelete('cascade');
        });
    }
};
