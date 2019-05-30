<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestAddRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('quest_characters', function (Blueprint $table) {
            $table->string('role')->nullable();
        });
        Schema::table('quest_locations', function (Blueprint $table) {
            $table->string('role')->nullable();
        });
        Schema::table('quest_organisations', function (Blueprint $table) {
            $table->string('role')->nullable();
        });
        Schema::table('quest_items', function (Blueprint $table) {
            $table->string('role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quest_characters', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        Schema::table('quest_locations', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        Schema::table('quest_organisations', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        Schema::table('quest_items', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
