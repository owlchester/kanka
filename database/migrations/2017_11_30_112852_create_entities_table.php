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
        // attribute_template
        Schema::create('entities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 18)->notNull();
            $table->string('name')->notNull();
            $table->boolean('is_private')->default(0);
            $table->integer('entity_id')->unsigned()->notNull();
            $table->integer('campaign_id')->unsigned()->notNull();

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            $table->index(['type', 'name', 'is_private']);
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
