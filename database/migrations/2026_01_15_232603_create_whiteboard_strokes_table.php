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
        Schema::create('whiteboard_strokes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shape_id')->cascadeOnDelete();
            $table->binary('points', 4294967295);
            $table->unsignedInteger('color');
            $table->unsignedBigInteger('width');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whiteboard_strokes');
    }
};
