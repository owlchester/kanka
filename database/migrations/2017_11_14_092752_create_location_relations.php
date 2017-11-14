<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('first_id')->unsigned()->notNull();
            $table->integer('second_id')->unsigned()->notNull();
            $table->string('relation', 45)->notNull();
            $table->timestamps();

            // Foreign
            $table->foreign('first_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('second_id')->references('id')->on('locations')->onDelete('cascade');

            // Index
            //$table->index([]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_relation');
    }
}
