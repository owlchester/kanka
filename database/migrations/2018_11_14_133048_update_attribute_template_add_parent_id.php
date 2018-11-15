<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAttributeTemplateAddParentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_templates', function (Blueprint $table) {
            $table->unsignedInteger('attribute_template_id')->nullable();
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->index(['_lft', '_rgt', 'attribute_template_id']);

            $table->foreign('attribute_template_id')->references('id')->on('attribute_templates')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute_templates', function (Blueprint $table) {
            $table->dropIndex(['lft', 'rgt', 'attribute_template_id']);
            $table->dropColumn('lft');
            $table->dropColumn('rgt');
            $table->dropColumn('attribute_template_id');
        });
    }
}
