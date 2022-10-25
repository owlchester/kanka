<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CreatureLocation
 * @package App\Models
 *
 * @property int $creature_id
 * @property int $location_id
 * @property Creature $creature
 * @property Location $location
 */
class CreatureLocation extends Pivot
{
    use Paginatable;

    /**
     * @var string
     */
    public $table = 'creature_location';

    /** @var string[]  */
    protected $fillable = ['creature_id', 'location_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creature()
    {
        return $this->belongsTo('App\Models\Creature', 'creature_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }
}
