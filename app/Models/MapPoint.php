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
 * @property string $name
 */
class MapPoint extends Model
{
    public $table = 'location_map_points';

    protected $fillable = [
        'location_id',
        'target_id',
        'axis_x',
        'axis_y',
        'colour',
        'name',
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

    /**
     * @return string
     */
    public function makePin()
    {
        $market = '<i class="fa fa-map-marker"' . ($this->colour == 'white' ? ' style="color: black;" ' : null) . '></i>';
        if (!$this->hasTarget()) {
            return '<a class="point" style="top: ' . $this->axis_y . 'px; left: ' . $this->axis_x . 'px; background-color: ' . $this->colour . ';" data-top="' . $this->axis_y . '" data-left="' . $this->axis_x . '" ' .
                'title="' . $this->name . '" data-toggle="tooltip">' . $market . '                    
            </a>';
        } else {
            $route = route('locations.show', [$this->target, (!empty($this->target->map) ? '#tab_map' : null)]);
            return '<a class="point" style="top: ' . $this->axis_y . 'px; left: ' . $this->axis_x . 'px; background-color: ' . $this->colour . ';" data-top="' . $this->axis_y . '" data-left="' . $this->axis_x . '" href="' .
                $route . '" title="' . $this->target->tooltipWithName() . '" data-toggle="tooltip" data-html="true">' . $market . '
            </a>';
        }
    }

    /**
     * @return bool
     */
    public function hasTarget()
    {
        return !empty($this->target_id);
    }
}
