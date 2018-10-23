<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('entity_files');
        Schema::create('entity_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->string('type', 20);
            $table->string('path', 191);
            $table->integer('size')->unsigned();
            $table->boolean('is_private')->default(0);

            $table->unsignedInteger('entity_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->index(['name', 'is_private', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_files', function (Blueprint $table) {
            //
        });
    }
}
