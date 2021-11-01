<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilyRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('first_id')->unsigned()->notNull();
            $table->integer('second_id')->unsigned()->notNull();
            $table->string('relation', 45)->notNull();
            $table->timestamps();

            // Foreign
            $table->foreign('first_id')->references('id')->on('families')->onDelete('cascade');
            $table->foreign('second_id')->references('id')->on('families')->onDelete('cascade');

            // Index
            //$table->index([]);
        });

        Schema::table('families', function (Blueprint $table) {
            $table->integer('location_id')->unsigned()->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_relation');
    }
}
