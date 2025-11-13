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
        Schema::dropIfExists('whiteboards');

        Schema::create('whiteboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->cascadeOnDelete();
            $table->string('name', 191)->index();
            $table->string('type', 45)->nullable();
            $table->json('data')->nullable();
            $table->boolean('is_private')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('created_by')->nullable()->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->nullOnDelete();

            $table->index(['name', 'type', 'is_private']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whiteboards');
    }
};
