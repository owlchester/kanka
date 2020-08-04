<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelineElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('timeline_elements');
        Schema::create('timeline_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('timeline_id');
            $table->unsignedBigInteger('era_id');
            $table->unsignedInteger('entity_id')->nullable();
            $table->unsignedInteger('position');
            $table->string('name', 191)->nullable();
            $table->string('date', 45)->nullable();
            $table->mediumText('entry')->nullable();
            $table->string('colour', 12)->default('grey');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();

            $table->enum('visibility', ['all', 'admin', 'admin-self', 'self'])->default('all');

            $table->index('position');

            $table->foreign('timeline_id')->references('id')->on('timelines')->onDelete('cascade');
            $table->foreign('era_id')->references('id')->on('timeline_eras')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timeline_elements');
    }
}
