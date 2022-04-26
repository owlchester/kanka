<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablesAddIndexesQ22020 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {



        Schema::table('attributes', function (Blueprint $table) {
            $table->index('default_order');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropIndex('campaigns_public_idx');
            $table->index(['visibility', 'is_featured', 'visible_entity_count']);
        });
        Schema::table('entities', function (Blueprint $table) {
            $table->index('updated_at');
        });
        Schema::table('conversation_messages', function (Blueprint $table) {
            $table->index('created_at');
        });
        Schema::table('organisation_member', function (Blueprint $table) {
            $table->index('role');
        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->index('read_at');
        });
        Schema::table('relations', function (Blueprint $table) {
            $table->index(['attitude', 'relation']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
