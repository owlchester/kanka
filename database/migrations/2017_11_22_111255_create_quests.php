<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campaign_id')->unsigned()->nullable();
            $table->integer('quest_id')->unsigned()->nullable();
            $table->string('name')->notNull();
            $table->string('slug')->nullable();
            $table->string('type', 45)->nullable();
            $table->longText('entry')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_private')->default(false)->notNull();
            $table->date('date')->nullable();

            $table->timestamps();


            // Indexes
            $table->index(['name', 'is_private']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('quest_id')->references('id')->on('quests')->onDelete('set null');
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('quests')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quests');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('quests');
        });
    }
}
