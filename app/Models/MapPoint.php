<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MapPoint
 * @package App\Models
 *
 * @property integer $location_id
 * @property integer $target_id
 * @property integer $axis_x
 * @property integer $axis_y
 * @property string $colour
 */
class MapPoint extends Model
{
    public $table = 'location_map_points';

    protected $fillable = [
        'location_id',
        'target_id',
        'axis_x',
        'axis_y',
        'colour'
    ];

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
