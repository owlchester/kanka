<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapPoint extends Model
{
    public $table = 'location_map_points';

    protected $fillable = ['location_id', 'target_id', 'axis_x', 'axis_y'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function target()
    {
        return $this->belongsTo('App\Models\Location', 'target_id');
    }
}
