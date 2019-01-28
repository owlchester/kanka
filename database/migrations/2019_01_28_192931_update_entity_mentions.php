<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEntityMentions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->integer('entity_note_id')->unsigned()->nullable()->after('entity_id');
            $table->integer('campaign_id')->unsigned()->nullable()->after('entity_note_id');
            $table->unsignedInteger('entity_id')->nullable()->change();

            $table->foreign('entity_note_id')->references('id')->on('entity_notes')->onDelete('cascade');
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
        Schema::table('entity_mentions', function (Blueprint $table) {
            $table->unsignedInteger('entity_id')->notNull()->change();

            $table->dropForeign('entity_mentions_entity_note_id_foreign');
            $table->dropColumn('entity_note_id');
            $table->dropForeign('entity_mentions_campaign_id_foreign');
            $table->dropColumn('campaign_id');
        });
    }
}
