<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleanupVisibilities extends Migration
{
    protected $tables = [
        'entity_links',
        'entity_files',
        'inventories',
        'calendar_weathers',
        'quest_elements',
        'entity_abilities',
        'timeline_elements',
        'relations'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tablename) {
            if (!Schema::hasColumn($tablename, 'visibility')) {
                continue;
            }

            Schema::table($tablename, function (Blueprint $table) {
                $table->dropColumn('visibility');
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
        // No down this time because it's a DB cleanup process.
    }
}
