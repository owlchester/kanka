<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateEntityLinksToVisibilityId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entity_links', function (Blueprint $table) {
            $table->unsignedBigInteger('visibility_id')
                ->after('visibility')
                ->default(1);
            $table->foreign('visibility_id')->references('id')->on('visibilities')->cascadeOnDelete();
        });

        \Illuminate\Support\Facades\DB::statement("UPDATE entity_links SET visibility_id = 2 WHERE visibility = 'admin'");
        \Illuminate\Support\Facades\DB::statement("UPDATE entity_links SET visibility_id = 3 WHERE visibility = 'admin-self'");
        \Illuminate\Support\Facades\DB::statement("UPDATE entity_links SET visibility_id = 4 WHERE visibility = 'self'");
        \Illuminate\Support\Facades\DB::statement("UPDATE entity_links SET visibility_id = 5 WHERE visibility = 'members'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entity_links', function (Blueprint $table) {
            $table->dropForeign('entity_links_visibility_id_foreign');
            $table->dropColumn('visibility_id');
        });
    }
}
