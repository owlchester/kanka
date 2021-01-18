<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignGalleryFolders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('image_folders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
            $table->string('name', 100);

            $table->index('name');

            $table->unsignedInteger('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('image_folders')->onDelete('cascade');
        });*/

        Schema::table('images', function (Blueprint $table) {
            $table->uuid('folder_id')->nullable();
            $table->boolean('is_folder')->default(false);
            $table->foreign('folder_id')->references('id')->on('images')->onDelete('cascade');

            $table->index('is_folder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign('images_folder_id_foreign');
            $table->dropColumn('folder_id');
            $table->dropColumn('is_folder');
        });
        //Schema::dropIfExists('image_folders');
    }
}
