<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('tags')
            ->whereIn('colour', [
                'red', 'yellow', 'brown', 'aqua', 'light-blue',
                'green', 'navy', 'teal', 'orange', 'purple',
                'maroon', 'grey', 'gray', 'pink', 'black',
            ])
            ->update([
                'colour' => DB::raw("CASE colour
                    WHEN 'red' THEN 'D93D33'
                    WHEN 'yellow' THEN 'f39c12'
                    WHEN 'brown' THEN 'a35831'
                    WHEN 'aqua' THEN '00829B'
                    WHEN 'light-blue' THEN '3A7CAD'
                    WHEN 'green' THEN '058943'
                    WHEN 'navy' THEN '001F3F'
                    WHEN 'teal' THEN '2D8289'
                    WHEN 'orange' THEN 'C85208'
                    WHEN 'purple' THEN '605ca8'
                    WHEN 'maroon' THEN 'D81B60'
                    WHEN 'grey' THEN '797676'
                    WHEN 'gray' THEN '797676'
                    WHEN 'pink' THEN 'C822D7'
                    WHEN 'black' THEN '111111'
                    ELSE colour
                END"),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('tags')
            ->whereIn('colour', [
                'D93D33', 'f39c12', 'a35831', '00829B', '3A7CAD',
                '058943', '001F3F', '2D8289', 'C85208', '605ca8',
                'D81B60', '797676', 'C822D7', '111111',
            ])
            ->update([
                'colour' => DB::raw("CASE colour
                    WHEN 'D93D33' THEN 'red'
                    WHEN 'f39c12' THEN 'yellow'
                    WHEN 'a35831' THEN 'brown'
                    WHEN '00829B' THEN 'aqua'
                    WHEN '3A7CAD' THEN 'light-blue'
                    WHEN '058943' THEN 'green'
                    WHEN '001F3F' THEN 'navy'
                    WHEN '2D8289' THEN 'teal'
                    WHEN 'C85208' THEN 'orange'
                    WHEN '605ca8' THEN 'purple'
                    WHEN 'D81B60' THEN 'maroon'
                    WHEN '797676' THEN 'grey'
                    WHEN 'C822D7' THEN 'pink'
                    WHEN '111111' THEN 'black'
                    ELSE colour
                END"),
            ]);
    }
};
