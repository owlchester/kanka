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
        Schema::create('category_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->string('key', 45);
            $table->string('icon', 45)->nullable();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->boolean('is_default')->default(false);

            $table->foreign('category_id')->references('id')->on('entity_types')->cascadeOnDelete();
            $table->unique(['category_id', 'key']);
            $table->index('sort_order');
            $table->index('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_statuses');
    }
};
