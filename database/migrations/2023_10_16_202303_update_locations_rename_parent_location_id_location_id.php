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
        Schema::table('locations', function (Blueprint $table) {
            $table->renameColumn('parent_location_id', 'location_id');
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->renameColumn('location_id', 'parent_location_id');
            $table->foreign('parent_location_id')->references('id')->on('locations')->nullOnDelete();
        });
    }
};
