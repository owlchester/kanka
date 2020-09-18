<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMapLayersOverlay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_layers', function (Blueprint $table) {
            $table->unsignedTinyInteger('type_id')->nullable();
        });

        Schema::table('maps', function (Blueprint $table) {
            $table->unsignedSmallInteger('center_x')->nullable();
            $table->unsignedSmallInteger('center_y')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_layers', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
        Schema::table('map_layers', function (Blueprint $table) {
            $table->dropColumn('center_x');
            $table->dropColumn('center_y');
        });
    }
}
