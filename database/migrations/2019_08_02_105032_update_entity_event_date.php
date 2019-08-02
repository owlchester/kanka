<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEntityEventDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_events', function (Blueprint $table) {
            $table->unsignedMediumInteger('day');
            $table->unsignedMediumInteger('month');
            $table->integer('year');

            $table->index(['day', 'month', 'year']);
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
            $table->dropColumn('day');
            $table->dropColumn('month');
            $table->dropColumn('year');
        });
    }
}
