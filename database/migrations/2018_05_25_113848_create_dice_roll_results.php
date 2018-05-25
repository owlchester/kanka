<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiceRollResults extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dice_rolls', function (Blueprint $table) {
            $table->dropForeign('dice_rolls_created_by_foreign');
            $table->dropColumn('created_by');
            $table->dropColumn('results');

            $table->string('image', 255)->nullable();

            $table->unsignedInteger('section_id')->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
        });

        Schema::dropIfExists('dice_roll_results');
        Schema::create('dice_roll_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dice_roll_id');
            $table->unsignedInteger('created_by');
            $table->text('results')->nullable();
            $table->timestamps();

            $table->foreign('dice_roll_id')->references('id')->on('dice_rolls')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dice_roll_results');

        Schema::table('dice_rolls', function (Blueprint $table) {
            $table->text('results')->nullable();
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
