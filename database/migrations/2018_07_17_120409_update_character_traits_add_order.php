<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCharacterTraitsAddOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('character_traits', function (Blueprint $table) {
            $table->unsignedSmallInteger('default_order')->null()->default('0');
            $table->index(['default_order', 'character_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('character_traits', function (Blueprint $table) {
            $table->dropColumn('default_order');
        });
    }
}
