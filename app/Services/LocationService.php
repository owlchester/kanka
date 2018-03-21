<?php

namespace App\Services;

use App\Models\Location;
use App\Models\MapPoint;
use Illuminate\Database\Eloquent\Model;

class LocationService
{
    /**
     * @var Location
     */
    public $location;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * LocationService constructor.
     * @param Location $location
     */
    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    /**
     * @param Model|null $model
     * @param string $attribute
     * @return array
     */
    public function dropdown(Model $model = null, $attribute = 'location')
    {
        $current = 0;
        if (!empty($model) && $model->$attribute) {
            $this->values[$model->$attribute->id] = $model->$attribute->name;
            $current = $model->$attribute->id;
        }

        $recent = $this->location->where('id', '<>', $current)->recent()->take(10)->get();
        foreach ($recent as $r) {
            $this->values[$r->id] = $r->name;
        }

        return $this->values;
    }

    /**
     * @return array
     */
    public function dropdownIds()
    {
        return array_keys($this->values);
    }

    /**
     * @param Location $location
     * @param array $data
     */
    public function managePoints(Location $location, $data = array())
    {
        // Get the existing ones to build an array of ids
        $existing = [];
        foreach ($location->mapPoints as $model) {
            $existing[$model->id] = $model;
        }

        foreach ($data['map_point'] as $key => $point) {
            if (isset($existing[$key])) {
                unset($existing[$key]);
                continue;
            }
            list($x, $y, $target) = explode('-', $point);
            $new = MapPoint::create([
                'location_id' => $location->id,
                'target_id' => $target,
                'axis_x' => $x,
                'axis_y' => $y
            ]);
        }

        // Delete old
        foreach ($existing as $id => $point) {
            $point->delete();
        }
    }
}
