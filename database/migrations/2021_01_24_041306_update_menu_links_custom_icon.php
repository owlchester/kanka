<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenuLinksCustomIcon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_links', function (Blueprint $table) {
            $table->string('icon', 45)->nullable()->change();
        });

        \Illuminate\Support\Facades\DB::statement('UPDATE menu_links set icon = null');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_links', function (Blueprint $table) {
            $table->string('icon', 45)->change();
        });
    }
}
