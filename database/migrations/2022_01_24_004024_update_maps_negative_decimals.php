<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMapsNegativeDecimals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_markers', function (Blueprint $table) {
            $table->float('longitude', 12, 5)->change();
            $table->float('latitude', 12, 5)->change();
        });

        /*Schema::table('maps', function(Blueprint $table) {

        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_markers', function (Blueprint $table) {
            $table->float('longitude', 10, 3)->unsigned()->change();
            $table->float('latitude', 10, 3)->unsigned()->change();
        });
    }
}
