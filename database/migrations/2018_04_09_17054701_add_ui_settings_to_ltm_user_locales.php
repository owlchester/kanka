<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUiSettingsToLtmUserLocales extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = \Config::get('laravel-translation-manager::config.table_prefix', '');
        Schema::table($prefix . 'ltm_user_locales', function (Blueprint $table) use ($prefix) {
            $table->dropIndex('ix_ltm_user_locales_user_id');

            $table->unique('user_id', 'ixk_user_id_users_id');
            $table->text('ui_settings')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = \Config::get('laravel-translation-manager::config.table_prefix', '');
        Schema::table($prefix . 'ltm_user_locales', function (Blueprint $table) use ($prefix) {
            $table->dropColumn('ui_settings');

            $table->dropUnique('ixk_user_id_users_id');
            $table->index(['user_id'], 'ix_ltm_user_locales_user_id');
        });
    }

}
