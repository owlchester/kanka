<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class RemoveMoreEnums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->unsignedTinyInteger('visibility_id')->default(1)->after('visibility');
            $table->index('visibility_id', 'campaign_visibility_idx');
        });
        DB::statement("UPDATE campaigns SET visibility_id = " . \App\Models\Campaign::VISIBILITY_PUBLIC . " where visibility = 'public'");


        Schema::table('conversations', function (Blueprint $table) {
            $table->unsignedTinyInteger('target_id')->default(1);
        });
        DB::statement("UPDATE conversations SET target_id = " . \App\Models\Conversation::TARGET_CHARACTERS . " where target = 'characters'");

        Schema::table('location_map_points', function (Blueprint $table) {
            $table->string('shape', 8)->change();
            $table->string('size', 9)->change();
        });

        Schema::table('character_traits', function (Blueprint $table) {
            $table->string('section', 10)->change();
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
            $table->dropColumn('visibility_id');
        });
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn('target_id');
        });
    }
}
