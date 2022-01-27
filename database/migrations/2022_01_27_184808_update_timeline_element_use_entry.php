<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTimelineElementUseEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timeline_elements', function (Blueprint $table) {
            $table->boolean('is_collapsed')->default(false);
            $table->boolean('use_entity_entry')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timeline_elements', function (Blueprint $table) {
            $table->removeColumn('use_entity_entry');
            $table->removeColumn('is_collapsed');
        });
    }
}
