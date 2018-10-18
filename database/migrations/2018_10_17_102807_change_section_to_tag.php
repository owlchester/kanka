<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSectionToTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('sections', 'tags');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->renameColumn('sections', 'tags');
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
                'tag',
                'section',
                'dice_roll',
                'conversation',
                'race'
            ])->notNull()->change();
        });

        DB::statement("UPDATE entities SET type = 'tag' where type = 'section'");


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
                'tag',
                'dice_roll',
                'conversation',
                'race'
            ])->notNull()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

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
                'tag',
                'dice_roll',
                'conversation',
                'race'
            ])->notNull()->change();
        });


        DB::statement("UPDATE entities SET type = 'section' where type = 'tag'");

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
                'tag',
                'section',
                'dice_roll',
                'conversation',
                'race'
            ])->notNull()->change();
        });




        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->renameColumn('tags', 'sections');
        });

        Schema::rename('tags', 'sections');
    }
}
