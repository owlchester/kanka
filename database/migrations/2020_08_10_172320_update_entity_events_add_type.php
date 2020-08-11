<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEntityEventsAddType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_event_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
        });

        Schema::table('entity_events', function (Blueprint $table) {
            $table->string('colour', 12)->change();
            $table->unsignedInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('entity_event_types')->onDelete('cascade');
            $table->unsignedInteger('elapsed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_events', function (Blueprint $table) {
            $table->string('colour', 191)->change();
            $table->dropColumn('type_id');
            $table->dropColumn('elapsed');
        });
        Schema::drop('entity_event_types');
    }
}
