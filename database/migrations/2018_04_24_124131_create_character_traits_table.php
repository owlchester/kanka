<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterTraitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('character_traits');
        Schema::create('character_traits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('character_id')->notNull();
            $table->unsignedInteger('created_by')->nullable();
            $table->string('name')->notNull();
            $table->text('entry')->nullable();
            $table->boolean('is_private')->default(0);
            $table->string('section', 12);
            $table->timestamps();

            // Foreign
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->index(['name', 'section', 'is_private']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_traits');
    }
}
