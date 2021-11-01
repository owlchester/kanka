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


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {



        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->renameColumn('tags', 'sections');
        });

        Schema::rename('tags', 'sections');
    }
}
