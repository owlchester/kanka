<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMapGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('map_groups');
        Schema::create('map_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('map_id');
            $table->unsignedInteger('created_by')->nullable();

            $table->string('name');
            $table->unsignedSmallInteger('position')->nullable();

            $table->enum('visibility', ['all', 'admin', 'admin-self', 'self'])->default('all');

            $table->timestamps();

            // Foreign
            $table->foreign('map_id')->references('id')->on('maps')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            // Index
            $table->index(['name', 'position', 'visibility']);
        });

        Schema::table('map_markers', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('map_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
