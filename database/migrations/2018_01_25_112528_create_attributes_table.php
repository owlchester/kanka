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
            $table->string('name')->notNull();
            $table->text('value', 191)->nullable();
            $table->string('type', 12)->nullable();
            $table->boolean('is_private')->default(0);
            $table->integer('entity_id')->unsigned()->notNull();

            $table->unsignedSmallInteger('default_order')->null()->default('0');
            $table->unsignedInteger('origin_attribute_id')->nullable();

            $table->boolean('is_star')->default(false);
            $table->string('api_key', 20)->null();

            $table->timestamps();

            // Foreign
            $table->foreign('origin_attribute_id')->references('id')->on('attributes')->onDelete('set null');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');

            $table->index(['name', 'is_private']);
            $table->index(['is_star'], 'attributes_is_star_idx');
            $table->index(['default_order']);
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
