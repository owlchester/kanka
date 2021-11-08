<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Campaign;

class MigrateCampaignVisibility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->unsignedTinyInteger('visibility_id')
                ->after('visibility')
                ->default(Campaign::VISIBILITY_PRIVATE);

            $table->dropIndex('campaigns_visibility_id_index');
            $table->dropIndex('campaigns_is_open_index');
            $table->dropIndex('campaigns_visibility_is_featured_visible_entity_count_index');
            $table->index(['visibility_id', 'system', 'is_open', 'locale', 'visible_entity_count', 'is_featured'], 'public_campaigns_ids');
        });

        \Illuminate\Support\Facades\DB::statement('UPDATE campaigns SET visibility_id = ' . Campaign::VISIBILITY_PUBLIC . ' WHERE visibility = \'public\'');

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('visibility', 20)
                ->after('visibility_id')
                ->default('users');

            $table->dropIndex('public_campaigns_ids');
            $table->index('is_open');
            $table->index(['visibility', 'id']);
            $table->index(['visibility', 'is_featured', 'visible_entity_count']);
        });
        \Illuminate\Support\Facades\DB::statement('UPDATE campaigns SET visibility = \'public\' WHERE visibility_id = ' . Campaign::VISIBILITY_PUBLIC);

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('visibility_id');
        });
    }
}
