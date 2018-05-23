<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDiceRolls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('dice_rolls');
        Schema::create('dice_rolls', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('character_id')->nullable();
            $table->string('name', 191);
            $table->string('slug')->nullable();
            $table->string('system', 20)->nullable();
            $table->text('parameters')->nullable();
            $table->text('results')->nullable();
            $table->boolean('is_private')->defaultValue(false);
            $table->timestamps();

            $table->index(['name', 'system', 'is_private']);

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('dice_rolls')->default(true);
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
        Schema::dropIfExists('dice_rolls');

        DB::statement("delete from entities where type = 'dice_roll'");

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('dice_rolls');
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
            ])->notNull()->change();
        });
    }
}
