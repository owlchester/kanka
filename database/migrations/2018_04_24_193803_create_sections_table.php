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
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('type', 45)->nullable();
            $table->string('image', 255)->nullable();
            $table->longText('entry')->nullable();
            $table->boolean('is_private')->default(false);
            $table->string('colour', 20)->nullable();

            $table->unsignedInteger('tag_id')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_auto_applied')->default(0);

            $table->timestamps();

            $table->index(['name', 'type', 'is_private', 'is_hidden', 'is_auto_applied']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('set null');
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('tags')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('tags');
        });
    }
}
