<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CharactersCleanup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('old_race');
            $table->dropColumn('eye_colour');
            $table->dropColumn('hair');
            $table->dropColumn('skin');
            $table->dropColumn('traits');
            $table->dropColumn('goals');
            $table->dropColumn('fears');
            $table->dropColumn('mannerisms');
            $table->dropColumn('languages');
            $table->dropColumn('free');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        throw new \Exception('Can\'t unrun characters_cleanup'); // can't unrun this
    }
}
