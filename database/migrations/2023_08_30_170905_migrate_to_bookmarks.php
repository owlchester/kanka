<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('menu_links', 'bookmarks');
        Schema::rename('menu_link_tag', 'bookmark_tag');

        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->renameColumn('menu_links', 'bookmarks');
        });
        Schema::table('bookmark_tag', function (Blueprint $table) {
            $table->renameColumn('menu_link_id', 'bookmark_id');
        });

        Illuminate\Support\Facades\DB::update("UPDATE bookmarks SET parent = 'bookmarks' WHERE parent = 'menu_links'");
        Illuminate\Support\Facades\DB::update("UPDATE bookmarks SET type = 'bookmark' WHERE type = 'menu_link'");
        Illuminate\Support\Facades\DB::update("UPDATE bookmarks SET menu = 'bookmark' WHERE menu = 'menu_link'");
        Illuminate\Support\Facades\DB::update("UPDATE bookmarks SET random_entity_type = 'bookmark' WHERE random_entity_type = 'menu_link'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('bookmarks', 'menu_links');
        Schema::rename('bookmark_tag', 'menu_link_tag');
        Schema::table('campaign_settings', function (Blueprint $table) {
            $table->renameColumn('bookmarks', 'menu_links');
        });
        Schema::table('menu_link_tag', function (Blueprint $table) {
            $table->renameColumn('bookmark_id', 'menu_link_id');
        });
    }
};
