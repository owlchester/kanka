<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Since mentions target aliases, we need to first improve aliases, and rename it, to keep IDs.
        Schema::table('entity_aliases', function (Blueprint $table) {
            $table->unsignedTinyInteger('type_id')->after('entity_id');
            $table->text('metadata')->after('name')->nullable();
            $table->unsignedSmallInteger('position')->nullable();
            $table->boolean('is_pinned')->default(0);

            $table->index(['type_id', 'is_pinned']);
        });

        DB::update('update entity_aliases set type_id = ' . \App\Enums\EntityAssetType::alias->value);

        Schema::rename('entity_aliases', 'entity_assets');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('entity_assets', 'entity_aliases');

        Schema::table('entity_aliases', function (Blueprint $table) {
            $table->dropIndex(['type_id']);
            $table->dropColumn('metadata');
            $table->dropColumn('position');
            $table->dropColumn('type_id');
        });

    }
}
