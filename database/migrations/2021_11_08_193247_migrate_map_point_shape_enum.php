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

            $table->unsignedTinyInteger('size_id')
                ->after('size')
                ->default(MapPoint::SHAPE_CIRCLE);
        });

        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET shape_id = ' . MapPoint::SHAPE_SQUARE . ' WHERE shape = \'square\'');
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET shape_id = ' . MapPoint::SHAPE_TRIANGLE . ' WHERE shape = \'triangle\'');


        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET size_id = ' . MapPoint::SIZE_TINY . ' WHERE size = \'tiny\'');
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET size_id = ' . MapPoint::SIZE_SMALL . ' WHERE size = \'small\'');
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET size_id = ' . MapPoint::SIZE_LARGE . ' WHERE size = \'large\'');
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET size_id = ' . MapPoint::SIZE_HUGE . ' WHERE size = \'huge\'');

        Schema::table('location_map_points', function (Blueprint $table) {
            $table->dropColumn('shape');
            $table->dropColumn('size');
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

            $table->string('size', 10)
                ->after('size_id')
                ->default('standard');
        });
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET shape = \'square\' WHERE shape_id = ' . MapPoint::SHAPE_SQUARE);
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET shape = \'triangle\' WHERE shape_id = ' . MapPoint::SHAPE_TRIANGLE);


        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET SIZE = \'tiny\' WHERE size_id = ' . MapPoint::SIZE_TINY);
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET SIZE = \'small\' WHERE size_id = ' . MapPoint::SIZE_SMALL);
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET SIZE = \'large\' WHERE size_id = ' . MapPoint::SIZE_LARGE);
        \Illuminate\Support\Facades\DB::statement('UPDATE location_map_points SET SIZE = \'huge\' WHERE size_id = ' . MapPoint::SIZE_HUGE);

        Schema::table('location_map_points', function (Blueprint $table) {
            $table->dropColumn('shape_id');
            $table->dropColumn('size_id');
        });
    }
}
