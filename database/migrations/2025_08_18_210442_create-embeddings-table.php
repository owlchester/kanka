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
        Schema::connection('vector_pgsql')->create('embeddings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('campaign_id');
            // pgvector column: 1536-dim embeddings (OpenAI/Prism)
            $table->addColumn('vector', 'embedding', ['dimensions' => 1536]);

            $table->unsignedBigInteger('parent_id');
            $table->string('parent_type');
            $table->timestamps();
            $table->index(['parent_id', 'parent_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('vector_pgsql')->dropIfExists('embeddings');
    }
};
