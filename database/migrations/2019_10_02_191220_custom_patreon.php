<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomPatreon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->unsignedInteger('theme_id')->nullable();
            $table->mediumText('css')->nullable();

            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('set null');
        });

        Schema::table('entities', function (Blueprint $table) {
            $table->text('tooltip')->nullable();
            $table->string('header_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('theme');
            $table->dropColumn('css');
        });

        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('tooltip');
            $table->dropColumn('header_image');
        });
    }
}
