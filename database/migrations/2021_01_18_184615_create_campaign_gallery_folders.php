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

        Schema::table('images', function (Blueprint $table) {
            $table->char('folder_id', 36)->nullable();
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
