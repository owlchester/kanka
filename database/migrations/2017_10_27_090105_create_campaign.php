<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('campaign_user');
        Schema::dropIfExists('campaigns');

        Schema::create('campaigns', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug');
            $table->string('locale', 5)->nullable();

            $table->string('image', 255)->nullable();
            $table->longText('entry')->nullable();

            $table->string('export_path')->nullable();
            $table->date('export_date')->nullable();

            $table->boolean('is_featured')->defaultValue(false);
            $table->boolean('entity_visibility')->defaultValue(false);

            $table->timestamps();

            $table->unique(['name', 'slug']);
            $table->index(['visibility', 'is_featured'], 'campaigns_public_idx');
        });

        Schema::create('campaign_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('campaign_id')->unsigned();
            $table->string('role', 6);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('campaign_user');
        Schema::drop('campaigns');
    }
}
