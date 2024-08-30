<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('entities')) {
            return;
        }
        Schema::create('entities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('type_id')->nullable();
            $table->string('name');
            $table->boolean('is_private')->default(0);
            $table->integer('entity_id')->unsigned();
            $table->integer('campaign_id')->unsigned();

            $table->text('tooltip')->nullable();
            $table->string('header_image')->nullable();

            $table->boolean('is_template')->nullable();
            $table->boolean('is_attributes_private')->default(false);

            $table->unsignedSmallInteger('focus_x')->nullable();
            $table->unsignedSmallInteger('focus_y')->nullable();

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();


            $table->timestamps();

            // Foreign
            $table->foreign('campaign_id')
                ->references('id')->on('campaigns')
                ->cascadeOnDelete();

            $table->foreign('created_by')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->index(['name', 'is_private', 'is_template']);
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entities');
    }
}
