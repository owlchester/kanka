<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateMoreToVisibilityId extends Migration
{
    protected $tableName = ['quest_elements', 'entity_events', 'entity_abilities', 'timeline_elements', 'relations'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tableName as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('visibility_id')
                    ->after('visibility')
                    ->default(1);
                $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();
            });

            \Illuminate\Support\Facades\DB::statement("UPDATE " . $tableName . " SET visibility_id = 2 WHERE visibility = 'admin'");
            \Illuminate\Support\Facades\DB::statement("UPDATE " . $tableName . " SET visibility_id = 3 WHERE visibility = 'admin-self'");
            \Illuminate\Support\Facades\DB::statement("UPDATE " . $tableName . " SET visibility_id = 4 WHERE visibility = 'self'");
            \Illuminate\Support\Facades\DB::statement("UPDATE " . $tableName . " SET visibility_id = 5 WHERE visibility = 'members'");
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tableName as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->dropForeign($tableName . '_visibility_id_foreign');
                $table->dropColumn('visibility_id');
            });
        }
    }
}
