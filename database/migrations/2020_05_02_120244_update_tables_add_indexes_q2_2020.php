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

        Schema::table('calendars', function (Blueprint $table) {
            $table->dropForeign('calendars_section_id_foreign');
            $table->dropColumn('section_id');
        });
        Schema::table('characters', function (Blueprint $table) {
            $table->dropForeign('characters_section_id_foreign');
            $table->dropColumn('section_id');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_section_id_foreign');
            $table->dropColumn('section_id');
        });
        Schema::table('families', function (Blueprint $table) {
            $table->dropForeign('families_section_id_foreign');
            $table->dropColumn('section_id');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_section_id_foreign');
            $table->dropColumn('section_id');
        });
        Schema::table('journals', function (Blueprint $table) {
            $table->dropForeign('journals_section_id_foreign');
            $table->dropColumn('section_id');
        });
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign('locations_section_id_foreign');
            $table->dropColumn('section_id');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign('notes_section_id_foreign');
            $table->dropColumn('section_id');
        });
        Schema::table('quests', function (Blueprint $table) {
            $table->dropForeign('quests_section_id_foreign');
            $table->dropColumn('section_id');
        });
        Schema::table('races', function (Blueprint $table) {
            $table->dropForeign('races_section_id_foreign');
            $table->dropColumn('section_id');
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->index('default_order');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropIndex('campaigns_public_idx');
            $table->index(['visibility', 'is_featured', 'visible_entity_count']);

            $table->dropColumn('join_token');
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
        Schema::table('posts', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
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
