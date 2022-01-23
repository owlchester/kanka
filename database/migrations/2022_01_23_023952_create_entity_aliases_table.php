<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityAliasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('entity_aliases');
        Schema::create('entity_aliases', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('entity_id');
            $table->unsignedInteger('created_by')->nullable();
            $table->bigInteger('visibility_id')->unsigned();
            $table->string('name', 191);
            $table->timestamps();

            $table->index(['name']);
            $table->foreign('entity_id')->references('id')->on('entities')->cascadeOnDelete();
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_aliases');
    }
}
