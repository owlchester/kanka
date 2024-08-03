<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntityImageId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->char('image_uuid', 36)->nullable();
            $table->char('header_uuid', 36)->nullable();

            $table->foreign('image_uuid')->references('id')->on('images')->nullOnDelete();
            $table->foreign('header_uuid')->references('id')->on('images')->nullOnDelete();
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
            $table->dropForeign('entities_image_uuid_foreign');
            $table->dropColumn('image_uuid');
        });
    }
}
