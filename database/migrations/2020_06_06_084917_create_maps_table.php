<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('location_id')->nullable();

            $table->string('name');
            $table->string('slug');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->unsignedInteger('map_id')->nullable();
            $table->boolean('is_private')->default(false);

            // Tree
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->index(['_lft', '_rgt', 'map_id']);

            // Overview
            $table->longText('entry')->nullable();

            $table->float('center_x', 8, 3)->nullable()->change();
            $table->float('center_y', 8, 3)->nullable()->change();

            $table->smallInteger('min_zoom')->nullable();
            $table->smallInteger('max_zoom')->nullable();
            $table->smallInteger('initial_zoom')->nullable();

            $table->unsignedSmallInteger('center_x')->nullable();
            $table->unsignedSmallInteger('center_y')->nullable();

            $table->unsignedSmallInteger('grid')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('set null');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');

            // Index
            $table->index(['name', 'slug', 'type']);
        });

        Schema::create('map_layers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('map_id');
            $table->unsignedInteger('created_by')->nullable();

            $table->string('name');
            $table->unsignedSmallInteger('position')->nullable();
            $table->string('image', 255)->nullable();
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();

            // Overview
            $table->longText('entry')->nullable();

            $table->string('visibility', 10)->default('all');

            $table->boolean('is_shown')->default(true);

            $table->unsignedTinyInteger('type_id')->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            // Index
            $table->index(['name', 'position', 'visibility']);
        });

        Schema::create('map_markers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('map_id');
            $table->unsignedInteger('entity_id')->nullable();
            $table->unsignedSmallInteger('pin_size')->nullable();

            $table->string('name')->nullable();
            $table->longText('entry')->nullable();
            $table->decimal('longitude', 10, 3)->unsigned();
            $table->decimal('latitude', 10, 3)->unsigned();
            $table->string('colour', 7)->nullable();
            $table->unsignedTinyInteger('shape_id')->default(1);
            $table->unsignedTinyInteger('size_id')->default(1);
            $table->string('icon', 20)->nullable();

            $table->text('custom_icon')->nullable();
            $table->text('custom_shape')->nullable();
            $table->boolean('is_draggable')->default(0);

            $table->unsignedInteger('created_by')->nullable();

            $table->string('visibility', 10)->default('all')->nullable();
            $table->string('font_colour', 7)->nullable();

            $table->smallInteger('circle_radius')->unsigned()->nullable();
            $table->text('polygon_style')->nullable();

            $table->tinyInteger('opacity')->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');

            // Index
            $table->index(['name', 'visibility']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('map_markers');
        Schema::drop('map_layers');
        Schema::drop('maps');
    }
}
