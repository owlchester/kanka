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
        Schema::dropIfExists('entity_locations');
        Schema::create('entity_locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('entity_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->unsignedInteger('created_by')->nullable();
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entity_locations');
    }
};
