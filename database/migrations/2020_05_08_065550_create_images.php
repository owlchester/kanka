<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('images');
        Schema::create('images', function (Blueprint $table) {
            $table->char('id', 36);
            $table->unsignedInteger('campaign_id');
            $table->string('name', 45)->nullable();
            $table->string('ext', 4)->nullable();
            $table->integer('size')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->boolean('is_default')->default(false);

            $table->unsignedBigInteger('visibility_id')->default(1);

            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();

            $table->unique('id');

            $table->index(['is_default']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
