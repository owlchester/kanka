<?php

namespace App\Models;

use App\Models\MiscModel;
use App\Traits\VisibleTrait;

class LocationAttribute extends MiscModel
{
    /**
     * Traits
     */
    use VisibleTrait;

    /**
     * @var string
     */
    public $table = 'location_attributes';

    /**
     * @var array
     */
    protected $fillable = ['location_id', 'attribute', 'value', 'is_private'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }
}
