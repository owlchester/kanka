<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTimelineElementsIcons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timeline_elements', function (Blueprint $table) {
            $table->text('icon')->nullable();
        });

        Schema::table('timelines', function (Blueprint $table) {
           $table->boolean('revert_order')->default(false);
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
            $table->dropColumn('icon');
        });
        Schema::table('timelines', function (Blueprint $table) {
            $table->dropColumn('revert_order');
        });
    }
}
