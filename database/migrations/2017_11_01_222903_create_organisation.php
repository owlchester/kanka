<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('image', 255)->nullable();

            $table->integer('campaign_id')->unsigned();
            $table->integer('location_id')->unsigned()->nullable();
            $table->unsignedInteger('organisation_id')->nullable();

            $table->longText('entry')->nullable();

            $table->boolean('is_private')->default(false);
            $table->boolean('is_defunct')->default(0);
            $table->timestamps();

            $table->index(['is_private']);
            $table->index('is_defunct');

            // Foreign
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('set null');

            // Index
            $table->index(['name', 'type']);
        });

        Schema::create('organisation_member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned();
            $table->integer('character_id')->unsigned();
            $table->string('role', 45)->nullable();
            $table->boolean('is_private')->default(false);

            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedTinyInteger('pin_id')->nullable();
            $table->unsignedTinyInteger('status_id')->default(0);
            $table->timestamps();

            // Foreign
            $table->foreign('organisation_id')->references('id')->on('organisations')->cascadeOnDelete();
            $table->foreign('character_id')->references('id')->on('characters')->cascadeOnDelete();
            $table->foreign('parent_id')->references('id')->on('organisation_member')->nullOnDelete();

            // Index
            $table->index(['is_private', 'role']);
            $table->index('pin_id');
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
