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
        Schema::table('entity_types', function (Blueprint $table) {
            $table->unsignedInteger('campaign_id')->nullable();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->cascadeOnDelete();
            $table->string('singular', 50)->nullable();
            $table->string('plural', 50)->nullable();
            $table->string('icon', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entity_types', function (Blueprint $table) {
            $table->dropForeign('entity_types_campaign_id_foreign');
            $table->dropColumn('campaign_id');
            $table->dropColumn('singular');
            $table->dropColumn('plural');
            $table->dropColumn('icon');
        });
    }
};
