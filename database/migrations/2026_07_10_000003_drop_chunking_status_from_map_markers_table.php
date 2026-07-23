<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('map_markers', function (Blueprint $table): void {
            $table->dropColumn('chunking_status');
        });
    }

    public function down(): void
    {
        Schema::table('map_markers', function (Blueprint $table): void {
            $table->unsignedTinyInteger('chunking_status')->nullable();
        });
    }
};
