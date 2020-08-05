<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('timeline_eras');
        Schema::dropIfExists('timelines');

        Schema::create('timelines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');

            $table->string('name');
            $table->string('slug');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();
            $table->unsignedInteger('calendar_id')->nullable();
            $table->boolean('is_private')->default(false);

            // Overview
            $table->longText('entry')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('set null');

            // Index
            $table->index(['name', 'slug', 'type']);
        });

        Schema::create('timeline_eras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('timeline_id');
            $table->unsignedInteger('created_by')->nullable();

            $table->string('name');
            $table->string('abbreviation')->nullable();
            $table->integer('start_year')->nullable();
            $table->integer('end_year')->nullable();

            // Overview
            $table->longText('entry')->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('timeline_id')->references('id')->on('timelines')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            // Index
            $table->index(['name', 'start_year']);
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('timelines')->default(true);
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
                'timeline',
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
        Schema::drop('timeline_eras');
        Schema::drop('timelines');

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

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('timelines');
        });
    }
}
