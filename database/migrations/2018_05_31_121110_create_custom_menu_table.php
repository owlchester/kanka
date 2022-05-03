<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('menu_links');
        Schema::create('menu_links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('entity_id')->nullable();
            $table->string('name', 100)->notNull()->index();
            $table->string('icon', 45)->nullable();
            $table->boolean('is_private')->defaultValue(false);

            $table->string('tab', 20)->nullable();
            $table->string('filters', 255)->nullable();
            $table->string('random_entity_type', 30)->nullable();
            $table->string('menu', 20)->nullable();
            $table->string('type', 30)->nullable();

            $table->unsignedSmallInteger('position')->default(1);

            $table->timestamps();

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');

            $table->index(['position']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_links');
    }
}
