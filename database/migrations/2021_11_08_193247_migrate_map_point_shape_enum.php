<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\MapPoint;

class MigrateMapPointShapeEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location_map_points', function (Blueprint $table) {
            $table->unsignedTinyInteger('shape_id')
                ->after('shape')
                ->default(MapPoint::SHAPE_CIRCLE);
        });

        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET shape_id = ' . MapPoint::SHAPE_SQUARE . ' WHERE shape = \'square\'');
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET shape_id = ' . MapPoint::SHAPE_TRIANGLE . ' WHERE shape = \'triangle\'');

        Schema::table('location_map_points', function (Blueprint $table) {
            $table->dropColumn('shape');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location_map_points', function (Blueprint $table) {
            $table->string('shape', 8)
                ->after('shape_id')
                ->default('circle');
        });
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET shape = \'square\' WHERE shape_id = ' . MapPoint::SHAPE_SQUARE);
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET shape = \'triangle\' WHERE shape_id = ' . MapPoint::SHAPE_TRIANGLE);

        Schema::table('location_map_points', function (Blueprint $table) {
            $table->dropColumn('target_id');
        });
    }
}
