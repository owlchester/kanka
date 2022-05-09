<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateQuestElementsChildless extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quest_elements', function (Blueprint $table) {
            $table->unsignedInteger('entity_id')->nullable()->change();
            $table->string('name', 100)->nullable();
        });

        if (app()->environment('testing')) {
            return;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quest_elements', function (Blueprint $table) {
            $table->unsignedInteger('entity_id')->change();
            $table->dropColumn('name');
        });
    }
}
