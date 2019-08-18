<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRpgSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rpg_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('code', 45);
            $table->unsignedTinyInteger('sort_order')->default(0);

            $table->index(['deleted_at', 'sort_order']);
        });

        Schema::create('campaign_rpg_system', function (Blueprint $table) {
           $table->unsignedInteger('campaign_id');
           $table->unsignedInteger('rpg_system_id');

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('rpg_system_id')->references('id')->on('rpg_systems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_rpg_system');
        Schema::drop('rpg_systems');
    }
}
