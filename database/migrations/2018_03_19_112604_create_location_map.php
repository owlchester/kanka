<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationMap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->string('map', 191)->nullable();
            $table->boolean('is_map_private')->default(0);
        });

        Schema::create('location_map_points', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('location_id')->unsigned()->notNull();
            $table->integer('target_id')->unsigned()->nullable();

            $table->integer('axis_x')->unsigned();
            $table->integer('axis_y')->unsigned();

            $table->string('colour', 7)->default('grey')->nullable();
            $table->string('name')->nullable();

            $table->string('shape', 8)->default('circle');
            $table->string('size', 10)->default('standard');
            $table->string('icon', 20)->default('pin');


            $table->integer('target_entity_id')->unsigned()->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('target_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('target_entity_id')->references('id')->on('entities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_map_points');
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('map');
        });
    }
}
