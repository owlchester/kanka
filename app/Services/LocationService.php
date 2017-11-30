<?php

namespace App\Services;

use App\Models\Location;
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
}
