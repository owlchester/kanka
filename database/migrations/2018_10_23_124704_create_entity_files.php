<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;
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

            $table->unsignedBigInteger('visibility_id')->default(1);
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();

            $table->index(['name', 'is_private', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {}
}
