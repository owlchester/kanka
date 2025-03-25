<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttributeTemplatesAddEntityTypeId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_templates', function (Blueprint $table) {
            $table->unsignedInteger('entity_type_id')->nullable();
            $table->foreign('entity_type_id')->references('id')->on('entity_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute_templates', function (Blueprint $table) {
            $table->dropColumn('entity_type_id');
        });
    }
}
