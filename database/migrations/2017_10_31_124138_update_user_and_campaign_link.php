<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->string('patreon_pledge', 10)->null();

            $table->unsignedSmallInteger('default_pagination')->notNull()->default('15');
            $table->string('date_format', 20)->notNull()->default('Y-m-d');

            $table->char('currency', 3)->nullable();
            $table->unsignedTinyInteger('booster_count')->nullable();

            $table->dateTime('last_login_at')->nullable();
            $table->boolean('has_last_login_sharing')->default(0);

            $table->string('theme', 20)->nullable();
            $table->text('profile')->nullable();

            $table->datetime('banned_until')->nullable();

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
