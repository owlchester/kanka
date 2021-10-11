<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_styles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedInteger('campaign_id');
            $table->string('name', 45);
            $table->text('content');
            $table->boolean('is_enabled');
            $table->softDeletes();

            $table->unsignedInteger('created_by')->nullable();

            $table->index('is_enabled');

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_styles');
    }
}
