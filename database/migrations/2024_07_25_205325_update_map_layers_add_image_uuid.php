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
        Schema::table('map_layers', function (Blueprint $table) {
            $table->char('image_uuid', 36)->after('image')->nullable();
            $table->foreign('image_uuid')->references('id')->on('images')->nullOnDelete();
        });
        Schema::table('map_layers', function (Blueprint $table) {
            $table->renameColumn('image', 'image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('map_layers', function (Blueprint $table) {
            $table->dropForeign('map_layers_image_uuid_foreign');
            $table->dropColumn('image_uuid');
        });
        Schema::table('map_layers', function (Blueprint $table) {
            $table->renameColumn('image_path', 'image');
        });
    }
};
