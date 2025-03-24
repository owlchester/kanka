<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('presets');
        Schema::dropIfExists('preset_types');
        Schema::create('preset_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code', 20);
        });

        Schema::create('presets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('visibility_id');
            $table->unsignedInteger('campaign_id');

            $table->string('name', 191);
            $table->json('config');

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();
            $table->foreign('type_id')->references('id')->on('preset_types')->cascadeOnDelete();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presets');
        Schema::dropIfExists('preset_types');
    }
};
