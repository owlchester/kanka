<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->index(['campaign_id', 'folder_id', 'is_folder', 'updated_at'], 'images_gallery_listing_index');
            $table->index(['campaign_id', 'ext'], 'images_campaign_ext_index');
        });
    }

    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropIndex('images_gallery_listing_index');
            $table->dropIndex('images_campaign_ext_index');
        });
    }
};
