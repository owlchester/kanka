<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('entity_assets', function (Blueprint $table) {
            $table->uuid('image_uuid')->nullable();
            $table->foreign('image_uuid')->references('id')->on('images')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entity_assets', function (Blueprint $table) {
            $table->dropForeign('entity_assets_image_uuid_foreign');
            $table->dropColumn('image_uuid');
        });
    }
};
