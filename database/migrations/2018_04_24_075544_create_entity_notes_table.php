<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('entity_notes');

        Schema::create('entity_notes', function (Blueprint $table) {
            $table->increments('id');
            ;
            $table->string('name');
            $table->longText('entry')->nullable();
            $table->boolean('is_private')->default(0);
            $table->unsignedInteger('entity_id');
            $table->unsignedInteger('created_by')->nullable();

            $table->integer('updated_by')->unsigned()->nullable();
            $table->unsignedBigInteger('visibility_id')->default(1);
            $table->smallInteger('position');

            $table->text('settings')->nullable();

            $table->timestamps();

            // Foreign
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();

            $table->index(['name', 'is_private']);
            $table->index(['position']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_notes');
    }
}
