<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersAddCardExpiration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $field = 'pm_last_four';
            if (Schema::hasColumn('users', 'card_brand')) {
                $field = 'card_last_four';
            }
            $table->dateTime('card_expires_at')->after($field)->nullable();
            $table->index(['card_expires_at'], 'idx_card_expires_at');
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
            $table->dropIndex('idx_card_expires_at');
            $table->dropColumn('card_expires_at');
        });
    }
}
