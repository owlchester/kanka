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
        Schema::create('timeline_elements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('timeline_id');
            $table->unsignedBigInteger('era_id');
            $table->unsignedInteger('entity_id')->nullable();
            $table->unsignedInteger('position');
            $table->string('name', 191)->nullable();
            $table->string('date', 45)->nullable();
            $table->mediumText('entry')->nullable();
            $table->string('colour', 10)->default('grey');
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();

            $table->unsignedBigInteger('visibility_id')->default(1);

            $table->text('icon')->nullable();

            $table->boolean('use_event_date')->default(false);
            $table->boolean('is_collapsed')->default(false);
            $table->boolean('use_entity_entry')->default(false);

            $table->index('position');

            $table->foreign('timeline_id')->references('id')->on('timelines')->onDelete('cascade');
            $table->foreign('era_id')->references('id')->on('timeline_eras')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();

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
