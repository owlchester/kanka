<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMapGroupsAddDefaultVisibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_groups', function (Blueprint $table) {
            $table->boolean('is_shown')->default(true);
        });
        Schema::table('map_markers', function (Blueprint $table) {
            $table->string('font_colour', 7)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_groups', function (Blueprint $table) {
            $table->dropColumn('is_shown');
        });
        Schema::table('map_markers', function (Blueprint $table) {
            $table->dropColumn('font_colour');
        });
    }
}
