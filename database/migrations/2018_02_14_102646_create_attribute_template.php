<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('attribute_templates');
        Schema::create('attribute_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name')->notNull();
            $table->integer('campaign_id')->unsigned()->notNull();
            $table->boolean('is_private')->default(false)->notNull();

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            // Indexes
            $table->index(['name', 'is_private']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('attribute_templates');
    }
}
