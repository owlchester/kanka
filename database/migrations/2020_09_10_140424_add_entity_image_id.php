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
        Schema::table('images', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
            $table->index(['is_default']);
        });

        \Illuminate\Support\Facades\DB::raw('UPDATE images SET is_default = 1');

        Schema::table('entities', function (Blueprint $table) {
            $table->uuid('image_uuid')->nullable();
            $table->foreign('image_uuid')->references('id')->on('images')->onDelete('set null');
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
