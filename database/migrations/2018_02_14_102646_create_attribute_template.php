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
            $table->integer('campaign_id')->unsigned()->notNull();
            $table->unsignedInteger('attribute_template_id')->nullable();


            $table->string('slug');
            $table->string('name')->notNull();
            $table->boolean('is_private')->default(false)->notNull();

            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);

            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('attribute_template_id')->references('id')->on('attribute_templates')->onDelete('set null');

            // Indexes
            $table->index(['name', 'is_private']);
            $table->index(['_lft', '_rgt', 'attribute_template_id']);
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
