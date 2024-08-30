<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('attributes');
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('value', 191)->nullable();
            $table->string('type', 12)->nullable();
            $table->boolean('is_private')->default(0);
            $table->integer('entity_id')->unsigned();

            $table->unsignedSmallInteger('default_order')->null()->default('0');
            $table->unsignedInteger('origin_attribute_id')->nullable();
            $table->unsignedTinyInteger('type_id')->default(1);

            $table->boolean('is_pinned')->default(false);
            $table->string('api_key', 20)->null();

            $table->boolean('is_hidden')->default(false);

            $table->timestamps();

            // Foreign
            $table->foreign('origin_attribute_id')->references('id')->on('attributes')->onDelete('set null');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');

            $table->index(['name', 'is_private', 'is_hidden', 'is_pinned', 'default_order'], 'attributes_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
