<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->boolean('is_appearance_pinned')->default(1)->change();
            $table->boolean('is_personality_pinned')->default(1)->change();
        });
    }

    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->boolean('is_appearance_pinned')->default(0)->change();
            $table->boolean('is_personality_pinned')->default(0)->change();
        });
    }
};
