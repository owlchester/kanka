<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('abilities');

        Schema::create('abilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();
            $table->unsignedInteger('campaign_id');
//            $table->unsignedInteger('character_id')->nullable();
//            $table->unsignedInteger('location_id')->nullable();
            $table->unsignedInteger('ability_id')->nullable();
            $table->boolean('is_private')->default(false);

            // Tree
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->index(['_lft', '_rgt', 'ability_id']);

            // Overview
            $table->longText('entry')->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('ability_id')->references('id')->on('abilities')->onDelete('cascade');

            // Index
            $table->index(['name', 'slug', 'type']);
        });


        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('abilities')->default(true);
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('abilities');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('abilities');
        });

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
            ])->change();
        });
    }
}
