<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('releases');
        Schema::create('releases', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('published_at');
            $table->dateTime('end_at')->nullable();
            $table->string('name', 255);
            $table->string('excerpt', 255);
            $table->string('link', 255);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedTinyInteger('category_id')->default(1);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');

            $table->index(['published_at', 'end_at']);
            $table->index(['category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('releases');
    }
}
