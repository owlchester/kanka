<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function ($table) {
                $table->dropForeign('users_role_id_foreign');
                $table->dropColumn('role_id');
            });
        }
        if (Schema::hasColumn('users', 'welcome_campaign_id')) {
            Schema::table('users', function ($table) {
                $table->dropColumn('welcome_campaign_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
