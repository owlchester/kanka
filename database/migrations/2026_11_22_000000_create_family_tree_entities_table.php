<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_tree_entities', function (Blueprint $table): void {
            $table->unsignedBigInteger('family_tree_id');
            $table->unsignedInteger('entity_id');

            $table->primary(['family_tree_id', 'entity_id']);
            $table->index(['entity_id', 'family_tree_id'], 'family_tree_entities_entity_tree_idx');

            $table->foreign('family_tree_id')->references('id')->on('family_trees')->cascadeOnDelete();
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_tree_entities');
    }
};
