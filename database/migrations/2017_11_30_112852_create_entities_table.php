<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id')->nullable();
            $table->string('type', 20)->notNull();
            $table->string('name')->notNull();
            $table->boolean('is_private')->default(0);
            $table->integer('entity_id')->unsigned()->notNull();
            $table->integer('campaign_id')->unsigned()->notNull();

            $table->text('tooltip')->nullable();
            $table->string('header_image')->nullable();

            $table->boolean('is_template')->nullable();

            $table->unsignedSmallInteger('focus_x')->nullable();
            $table->unsignedSmallInteger('focus_y')->nullable();


            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->index(['type', 'name', 'is_private', 'is_template']);
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entities');
    }
}
