<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAbilitiesAddCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('abilities', function (Blueprint $table) {
            $table->string('charges', 120)->nullable();
        });
        Schema::table('entity_abilities', function (Blueprint $table) {
            $table->tinyInteger('charges')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abilities', function (Blueprint $table) {
            $table->dropColumn('charges');
        });
        Schema::table('entity_abilities', function (Blueprint $table) {
            $table->dropColumn('charges');
        });
    }
}
