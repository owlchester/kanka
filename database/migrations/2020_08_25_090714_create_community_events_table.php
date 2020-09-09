<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->unique();
            $table->mediumText('entry')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('image')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();

            $table->index(['end_at', 'start_at']);
        });

        Schema::create('community_event_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('community_event_id');

            $table->string('link', 191);
            $table->text('comment')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->tinyInteger('rank')->nullable();
            $table->index(['rank']);
            //$table->unsignedInteger('entity_id')->nullable();

            $table->foreign('community_event_id')->references('id')->on('community_events')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            //$table->foreign('entity_id')->references('id')->on('entities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_event_entries');
        Schema::dropIfExists('community_events');
    }
}
