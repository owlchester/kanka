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
        Schema::create('whiteboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->cascadeOnDelete();
            $table->string('name')->index();
            $table->json('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->nullOnDelete();
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
