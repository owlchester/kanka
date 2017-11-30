<?php

namespace App\Models;

use App\Models\Location;
use Illuminate\Database\Eloquent\Model;

class LocationRelation extends Model
{
    public $table = 'location_relation';

    protected $fillable = ['first_id', 'second_id', 'relation'];

    public function first()
    {
        return $this->belongsTo(Location::class, 'first_id');
    }

    public function second()
    {
        return $this->belongsTo(Location::class, 'second_id');
    }
    //
}
