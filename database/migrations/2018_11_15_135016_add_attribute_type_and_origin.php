<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributeTypeAndOrigin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->unsignedInteger('origin_attribute_id')->nullable();

            $table->foreign('origin_attribute_id')->references('id')->on('attributes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attributes', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropForeign('attributes_origin_attribute_id_foreign');
            $table->dropColumn('origin_attribute_id');
        });
    }
}
