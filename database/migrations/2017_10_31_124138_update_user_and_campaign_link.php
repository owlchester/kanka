<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserAndCampaignLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('last_campaign_id')->nullable();

            $table->string('password')->nullable()->change();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();

            $table->string('locale', 5)->default('en');

            $table->index(['provider', 'provider_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_campaign_id');
        });
    }
}
