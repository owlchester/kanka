<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class RaceLocation
 * @package App\Models
 *
 * @property int $race_id
 * @property int $location_id
 * @property Race $race
 * @property Location $location
 */
class RaceLocation extends Pivot
{
    use Paginatable;

    /**
     * @var string
     */
    public $table = 'race_location';

    /** @var string[]  */
    protected $fillable = ['race_id', 'location_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function race()
    {
        return $this->belongsTo('App\Models\Race', 'race_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    public function exportFields(): array
    {
        return ['location_id'];
    }
}
