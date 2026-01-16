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
        Schema::dropIfExists('whiteboard_shapes');
        Schema::create('whiteboard_shapes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('whiteboard_id');
            $table->unsignedBigInteger('group_id')->nullable();

            $table->string('type');
            $table->bigInteger('x');
            $table->bigInteger('y');
            $table->bigInteger('scale_x');
            $table->bigInteger('scale_y');
            $table->bigInteger('width');
            $table->bigInteger('height');
            $table->bigInteger('rotation');
            $table->bigInteger('z_index');
            $table->boolean('is_locked')->default(false);

            $table->json('shape');
            $table->foreignId('created_by')->nullable()->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('whiteboard_id')->references('id')->on('whiteboards')->cascadeOnDelete();
            $table->foreign('group_id')->references('id')->on('whiteboard_shapes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whiteboard_shapes');
    }
};
