<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSectionToTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('sections', 'tags');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->renameColumn('sections', 'tags');
        });

        DB::statement("UPDATE entities SET type = 'tag' where type = 'section'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::statement("UPDATE entities SET type = 'section' where type = 'tag'");

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->renameColumn('tags', 'sections');
        });

        Schema::rename('tags', 'sections');
    }
}
