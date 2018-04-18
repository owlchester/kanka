<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('faq_categories');
        Schema::create('faq_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('locale', 5)->default('en')->notNull();
            $table->string('title', 45)->notNull();
            $table->integer('order')->unsigned()->notNull();
            $table->boolean('is_visible')->default(true)->notNull();
            $table->timestamps();

            $table->index(['locale', 'order', 'is_visible']);
        });

        Schema::dropIfExists('faq');
        Schema::create('faq', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('faq_category_id')->notNull();
            $table->string('locale', 5)->notNull()->default('en');
            $table->text('question')->notNull();
            $table->text('answer')->notNull();
            $table->integer('order')->unsigned()->notNull();
            $table->boolean('is_visible')->default(true)->notNull();
            $table->timestamps();

            $table->index(['locale', 'order', 'is_visible']);

            // Foreign
            $table->foreign('faq_category_id')->references('id')->on('faq_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq');
        Schema::dropIfExists('faq_categories');
    }
}
