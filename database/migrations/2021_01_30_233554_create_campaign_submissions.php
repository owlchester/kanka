<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->boolean('is_open')->default(false);
            $table->index(['is_open']);
        });

        Schema::create('campaign_submissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('campaign_id');
            $table->text('text');

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
        Schema::dropIfExists('campaign_submissions');

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropIndex('campaigns_is_open_index');
            $table->dropColumn('is_open');
        });
    }
}
