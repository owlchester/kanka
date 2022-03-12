<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKbTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_category_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedInteger('faq_category_id');
            $table->string('title', 45)->notNull();
            $table->string('locale', 5)->notNull();

            $table->foreign('faq_category_id')->references('id')->on('faq_categories')->cascadeOnDelete();
        });

        Schema::create('faq_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedInteger('faq_id');
            $table->string('question', 191)->notNull();
            $table->text('answer')->notNull();
            $table->string('locale', 5)->notNull();

            $table->foreign('faq_id')->references('id')->on('faq')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_translations');
        Schema::dropIfExists('faq_cateogry_translations');
    }
}
