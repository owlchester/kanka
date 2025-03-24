<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'card_brand')) {
                $table->renameColumn('card_brand', 'pm_type');
            }
            if (Schema::hasColumn('users', 'card_last_four')) {
                $table->renameColumn('card_last_four', 'pm_last_four');
            }
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
            if (Schema::hasColumn('users', 'pm_type')) {
                $table->renameColumn('pm_type', 'card_brand');
            }
            if (Schema::hasColumn('users', 'pm_last_four')) {
                $table->renameColumn('pm_last_four', 'card_last_four');
            }
        });
    }
};
