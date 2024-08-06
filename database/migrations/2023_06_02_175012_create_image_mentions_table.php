<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('image_mentions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('entity_id');
            $table->char('image_id', 36);
            $table->unsignedInteger('post_id')->nullable();
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('entity_notes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('image_mentions', function (Blueprint $table) {
            Schema::dropIfExists('image_mentions');
        });
    }
};
