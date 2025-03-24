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
        Schema::create('organisation_location', function (Blueprint $table) {
            $table->unsignedInteger('organisation_id');
            $table->unsignedInteger('location_id');

            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisation_location');
    }
};
