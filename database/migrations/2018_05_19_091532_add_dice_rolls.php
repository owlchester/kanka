<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddDiceRolls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('dice_rolls');
        Schema::create('dice_rolls', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('character_id')->nullable();
            $table->string('name', 191);
            $table->string('system', 20)->nullable();
            $table->text('parameters')->nullable();
            $table->boolean('is_private')->default(false);
            $table->timestamps();

            $table->index(['name', 'system', 'is_private']);

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('dice_rolls')->default(true);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dice_rolls');

        DB::statement("delete from entities where type = 'dice_roll'");

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('dice_rolls');
        });

    }
}
