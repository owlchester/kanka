<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEntityNotesMarketplaceUuid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_notes', function (Blueprint $table) {
            $table->char('marketplace_uuid', 36)->nullable();
            $table->index('marketplace_uuid');
            $table->unsignedInteger('location_id')->nullable();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_notes', function (Blueprint $table) {
            $table->dropColumn('marketplace_uuid');
            $table->dropColumn('location_id');
        });
    }
}
