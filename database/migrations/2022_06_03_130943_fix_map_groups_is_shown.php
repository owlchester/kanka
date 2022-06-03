<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixMapGroupsIsShown extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('map_groups', 'is_shown')) {
            return;
        }
        Schema::table('map_groups', function (Blueprint $table) {
            $table->boolean('is_shown')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_groups', function (Blueprint $table) {
            //
        });
    }
}
