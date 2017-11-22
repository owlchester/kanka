<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('character_id')->unsigned()->notNull();
            $table->string('attribute', 191)->notNull();
            $table->string('value', 191)->notNull();
            $table->boolean('is_private')->default(false);
            $table->timestamps();

            // Foreign
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');

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
        Schema::dropifExists('character_attributes');
    }
}
