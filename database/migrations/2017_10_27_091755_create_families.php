<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Cleanup
        Schema::dropIfExists('family_member');
        Schema::dropIfExists('families');

        Schema::create('families', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('name')->notNull();
            $table->string('slug');
            $table->integer('campaign_id')->unsigned()->notNull();

            $table->longText('entry')->nullable();

            $table->string('banner')->nullable();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            // Indexes
            $table->index(['name', 'slug']);
        });

        Schema::create('family_member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('character_id')->unsigned()->notNull();
            $table->integer('family_id')->unsigned()->notNull();
            $table->timestamps();

            // Indexes
            //$table->index(['type']);

            // Foreign
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_member');
        Schema::dropIfExists('families');
    }
}
