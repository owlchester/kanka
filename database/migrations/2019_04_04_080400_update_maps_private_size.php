<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMapsPrivateSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->boolean('is_map_private')->default(0);
        });

        Schema::table('location_map_points', function (Blueprint $table) {
            $table->enum('size', ['standard', 'small', 'tiny', 'large', 'huge'])->default('standard')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('is_map_private');
        });

        Schema::table('location_map_points', function (Blueprint $table) {
            $table->enum('size', ['standard', 'small', 'large'])->default('standard')->change();
        });
    }
}
