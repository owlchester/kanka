<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campaign_descriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('campaign_id')->unique();
            $table->longText('description')->nullable();
            $table->text('excerpt')->nullable();
            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
        });

        // Copy existing entry and excerpt data into the new table
        DB::statement('
            INSERT INTO campaign_descriptions (campaign_id, description, excerpt, created_at, updated_at)
            SELECT id, entry, excerpt, NOW(), NOW()
            FROM campaigns
            WHERE entry IS NOT NULL OR excerpt IS NOT NULL
        ');

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['entry', 'excerpt']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->longText('entry')->nullable();
            $table->text('excerpt')->nullable();
        });

        DB::statement('
            UPDATE campaigns c
            INNER JOIN campaign_descriptions cd ON cd.campaign_id = c.id
            SET c.entry = cd.description, c.excerpt = cd.excerpt
        ');

        Schema::dropIfExists('campaign_descriptions');
    }
};
