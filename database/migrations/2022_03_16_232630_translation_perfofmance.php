<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TranslationPerfofmance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faq_translations', function (Blueprint $table) {
            $table->index(['locale'], 'idx_locale');
        });
        Schema::table('faq_category_translations', function (Blueprint $table) {
            $table->index(['locale'], 'idx_locale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faq_translations', function (Blueprint $table) {
            $table->dropIndex('idx_locale');
        });
        Schema::table('faq_category_translations', function (Blueprint $table) {
            $table->dropIndex('idx_locale');
        });
    }
}
