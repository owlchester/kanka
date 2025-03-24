<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->integer('campaign_id')->unsigned();
            $table->unsignedInteger('attribute_template_id')->nullable();

            $table->string('name');
            $table->boolean('is_private')->default(false);

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('attribute_template_id')->references('id')->on('attribute_templates')->onDelete('set null');

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

        Schema::dropIfExists('attribute_templates');
    }
}
