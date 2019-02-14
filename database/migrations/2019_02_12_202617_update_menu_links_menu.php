<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMenuLinksMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_links', function(Blueprint $table) {
            $table->string('menu', 20)->nullable();
            $table->string('type', 30)->nullable();

            $table->unsignedInteger('entity_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_links', function(Blueprint $table) {
            $table->dropColumn('menu');
            $table->dropColumn('type');
        });
    }
}
