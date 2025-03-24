<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('name');
            $table->integer('campaign_id')->unsigned();

            $table->integer('family_id')->unsigned()->nullable();

            $table->string('type', 45)->nullable();
            $table->longText('entry')->nullable();

            $table->string('image')->nullable();

            // Privacy
            $table->boolean('is_private')->default(false);
            $table->index(['is_private']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('family_id')->references('id')->on('families')->onDelete('set null');

            // Indexes
            $table->index(['name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('families');
    }
}
