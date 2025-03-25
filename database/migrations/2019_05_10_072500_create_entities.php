<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 45);
            $table->boolean('is_special')->default(false);
            $table->boolean('is_enabled')->default(true);
            $table->unsignedTinyInteger('position')->default(0);

            $table->timestamps();

            $table->index(['position', 'is_enabled', 'is_special']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('entity_types');
    }
}
