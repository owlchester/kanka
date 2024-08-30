<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('creatures');

        Schema::create('creatures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id');
            $table->unsignedInteger('creature_id')->nullable();
            $table->string('name', 191);
            $table->string('image', 255)->nullable();
            $table->string('type', 45)->nullable();
            $table->longText('entry')->nullable();
            $table->boolean('is_private')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->index(['name', 'type', 'is_private']);

            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('creature_id')->references('id')->on('creatures')->onDelete('set null');
        });

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->boolean('creatures')->default(true);
        });

        Schema::create('creature_location', function (Blueprint $table) {

            $table->unsignedInteger('creature_id');
            $table->unsignedInteger('location_id');

            $table->foreign('creature_id')->references('id')->on('creatures')->cascadeOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creature_location');
        Schema::dropIfExists('creatures');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->dropColumn('creatures');
        });
    }
};
