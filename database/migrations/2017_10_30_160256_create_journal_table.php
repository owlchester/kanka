<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->string('slug');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();
            $table->date('date')->nullable();
            $table->unsignedInteger('campaign_id')->notNull();
            $table->unsignedInteger('character_id')->nullable();
            $table->unsignedInteger('location_id')->nullable();

            // Overview
            $table->longText('entry')->nullable();

            $table->timestamps();

            // Privacy
            $table->boolean('is_private')->default(false);
            $table->index(['is_private']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('character_id')->references('id')->on('characters')->nullOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();

            // Index
            $table->index(['name', 'slug', 'type', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journals');
    }
}
