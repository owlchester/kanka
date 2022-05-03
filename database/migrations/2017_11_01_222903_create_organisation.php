<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganisation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->notNull();
            $table->string('slug');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();

            $table->integer('campaign_id')->unsigned()->notNull();
            $table->integer('location_id')->unsigned()->nullable();
            $table->unsignedInteger('organisation_id')->nullable();
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);

            // Overview
            $table->longText('entry')->nullable();

            $table->timestamps();

            // Privacy
            $table->boolean('is_private')->default(false);
            $table->index(['is_private']);

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('set null');

            // Index
            $table->index(['name', 'slug', 'type']);
            $table->index(['_lft', '_rgt', 'organisation_id']);
        });

        Schema::create('organisation_member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned()->notNull();
            $table->integer('character_id')->unsigned()->notNull();
            $table->string('role', 45)->nullable();
            $table->boolean('is_private')->default(false);
            $table->timestamps();

            // Foreign
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('character_id')->references('id')->on('characters')->cascadeOnDelete();

            // Index
            $table->index(['is_private', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisation_member');
        Schema::dropIfExists('organisations');
    }
}
