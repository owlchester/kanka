<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class UpdateForeignKeySchemas extends Migration
{
    protected $tables = [
        'items' => [
            'character',
            'location'
        ],
        'characters' => [
            'family',
        ],
        'families' => [
            'location',
        ],
        'organisations' => [
            'location',
        ]
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tableName => $fields) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName, $fields) {
                foreach ($fields as $field) {
                    $table->dropForeign($tableName . '_' . $field . '_id_foreign');
                    $table->foreign($field . '_id')
                        ->references('id')->on(Str::plural($field))
                        ->onDelete('set null');
                }
            });
        }

        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign('locations_parent_location_id_foreign');
            $table->foreign('parent_location_id')
                ->references('id')->on('locations')
                ->onDelete('set null');
        });


        Schema::table('organisation_member', function (Blueprint $table) {
            $table->dropForeign('organisation_member_organisation_id_foreign');
            $table->foreign('organisation_id')
                ->references('id')->on('organisations')
                ->onDelete('cascade');

            $table->dropForeign('organisation_member_character_id_foreign');
            $table->foreign('character_id')
                ->references('id')->on('characters')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $tableName => $fields) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName, $fields) {
                foreach ($fields as $field) {
                    $table->dropForeign($tableName . '_' . $field . '_id_foreign');
                    $table->foreign($field . '_id')
                        ->references('id')->on(Str::plural($field))
                        ->onDelete('cascade');
                }
            });
        }

        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign('locations_parent_location_id_foreign');
            $table->foreign('parent_location_id')
                ->references('id')->on('locations')
                ->onDelete('cascade');
        });

        Schema::table('organisation_member', function (Blueprint $table) {
            $table->dropForeign('organisation_member_organisation_id_foreign');
            $table->foreign('organisation_id')
                ->references('id')->on('organisations')
                ->onDelete('restrict');

            $table->dropForeign('organisation_member_character_id_foreign');
            $table->foreign('character_id')
                ->references('id')->on('characters')
                ->onDelete('restrict');
        });
    }
}
