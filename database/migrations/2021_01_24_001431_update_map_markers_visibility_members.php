<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMapMarkersVisibilityMembers extends Migration
{
    protected $tables = [
        'map_markers',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('visibility', 10)->change();
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
        foreach ($this->tables as $tableName) {
            DB::statement("ALTER TABLE $tableName CHANGE visibility visibility ENUM('all', 'admin', 'admin-self', 'self') CHARACTER SET utf8mb4 DEFAULT 'all' NOT NULL");
        }
    }
}
