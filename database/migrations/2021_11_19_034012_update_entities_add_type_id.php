<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEntitiesAddTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entities', function (Blueprint $table) {
            if (! app()->environment('testing') && ! Schema::hasColumn('entities', 'type_id')) {
                $table->unsignedInteger('type_id')->after('type')->nullable();
            }
            $table->foreign('type_id')->references('id')->on('entity_types')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('type_id');
        });
    }
}
