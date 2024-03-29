<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEntityLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('entity_id');
            $table->string('name', 45);
            $table->string('icon', 45);
            $table->unsignedTinyInteger('position')->default(0);
            $table->text('url');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedBigInteger('visibility_id')->default(1);
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();

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
        Schema::dropIfExists('entity_links');
    }
}
