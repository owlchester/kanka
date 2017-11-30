<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

            $table->integer('owner_id')->unsigned()->notNull();
            $table->integer('target_id')->unsigned()->notNull();
            $table->integer('campaign_id')->unsigned()->notNull();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('target_id')->references('id')->on('entities')->onDelete('cascade');

            $table->index(['owner_id', 'campaign_id', 'is_private']);

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
