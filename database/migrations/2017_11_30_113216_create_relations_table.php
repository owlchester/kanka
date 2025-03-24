<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('relations');
        Schema::create('relations', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_private')->default(0);

            $table->integer('owner_id')->unsigned();
            $table->integer('target_id')->unsigned();
            $table->integer('campaign_id')->unsigned();

            $table->string('relation', 255);
            $table->string('colour', 6)->nullable();
            $table->tinyInteger('attitude')->default(0)->nullable();

            $table->boolean('is_pinned')->default(false);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();

            $table->unsignedInteger('mirror_id')->nullable();
            $table->unsignedBigInteger('visibility_id')->default(1);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('owner_id')->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('target_id')->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('mirror_id')->references('id')->on('relations')->nullOnDelete();
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();

            $table->index(['is_private', 'attitude', 'relation', 'is_pinned']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relations');
    }
}
