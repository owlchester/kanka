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
        Schema::create('post_layouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 25);
            $table->unsignedInteger('entity_type_id')->nullable();
            $table->json('config')->nullable();
            $table->timestamps();

            $table->foreign('entity_type_id')->references('id')->on('entity_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_layouts');
    }
};
