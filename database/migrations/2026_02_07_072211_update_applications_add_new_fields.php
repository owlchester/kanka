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
        Schema::table('applications', function (Blueprint $table) {
            $table->text('character_concept')->nullable();
            $table->tinyInteger('experience')->default(0);
            $table->json('availability_days')->nullable();
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->string('timezone')->nullable();
            $table->tinyInteger('pref_rp_combat')->default(1);
            $table->tinyInteger('pref_tone')->default(1);
            $table->string('external_link')->nullable();
            $table->string('additional_notes')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn([
                'character_concept', 'experience', 'availability_days', 
                'time_start', 'time_end', 'timezone', 
                'pref_rp_combat', 'pref_tone', 'external_link', 'additional_notes'
            ]);
        });
    }
};
