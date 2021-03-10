<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMapMarkersMoreStyleOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_markers', function (Blueprint $table) {
            $table->smallInteger('circle_radius')->unsigned()->nullable();
            $table->text('polygon_style')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_markers', function (Blueprint $table) {
            $table->dropColumn('circle_radius');
            $table->dropColumn('polygon_style');
        });
    }
}
