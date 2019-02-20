<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAttributesValText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attributes', function(Blueprint $table) {
            $table->text('value')->nullable()->change();
            $table->string('type', 12)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attributes', function(Blueprint $table) {
            $table->string('value', 191)->nullable()->change();
            $table->string('type', 191)->nullable()->change();
        });
    }
}
