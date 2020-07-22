<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCampaignAddMaps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('maps')->default(true);
        });

        // Update entities
        Schema::table('entities', function (Blueprint $table) {
            $table->enum('type', [
                'character',
                'event',
                'family',
                'item',
                'journal',
                'location',
                'note',
                'organisation',
                'quest',
                'attribute_template',
                'calendar',
                'section',
                'dice_roll',
                'conversation',
                'race',
                'tag',
                'ability',
                'map',
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('maps');
        });

        // Update entities
        Schema::table('entities', function (Blueprint $table) {
            $table->enum('type', [
                'character',
                'event',
                'family',
                'item',
                'journal',
                'location',
                'note',
                'organisation',
                'quest',
                'attribute_template',
                'calendar',
                'section',
                'dice_roll',
                'conversation',
                'race',
                'tag',
                'ability'
            ])->change();
        });
    }
}
