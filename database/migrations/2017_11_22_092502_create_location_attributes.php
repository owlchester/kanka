<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropifExists('location_attributes');
        Schema::create('location_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->unsigned()->notNull();
            $table->string('attribute', 191)->notNull();
            $table->string('value', 191)->notNull();
            $table->boolean('is_private')->default(false);
            $table->timestamps();

            // Foreign
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');

            // Index
            $table->index(['attribute', 'is_private']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropifExists('location_attributes');
    }
}
