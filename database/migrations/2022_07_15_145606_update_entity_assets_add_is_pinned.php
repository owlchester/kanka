<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEntityAssetsAddIsPinned extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_assets', function (Blueprint $table) {
            $table->boolean('is_pinned')->default(0);
            $table->index('is_pinned');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_assets', function (Blueprint $table) {
            $table->dropIndex(['is_pinned']);
            $table->dropColumn('is_pinned');
        });
    }
}
