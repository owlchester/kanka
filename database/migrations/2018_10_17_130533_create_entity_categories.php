<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('entity_tags');

        Schema::create('entity_tags', function (Blueprint $table) {
            $table->increments('id');
            //            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('entity_id');
            $table->unsignedInteger('tag_id');
            $table->timestamps();

            //            $table->unsignedInteger('created_by')->nullable();
            //            $table->unsignedInteger('updated_by')->nullable();

            //            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            //            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            //            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_tags');
    }
}
