<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->string('name')->notNull();
            $table->string('slug')->nullable();
            $table->string('type', 45)->nullable();
            $table->string('image', 255)->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_private')->default(false)->notNull();

            $table->unsignedInteger('section_id')->nullable();
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);

            $table->timestamps();

            $table->index(['name', 'type', 'is_private']);
            $table->index(['section_id', '_lft', '_rgt']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
        });


        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('sections')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');


        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('sections');
        });
    }
}
