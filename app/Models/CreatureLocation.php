<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CreatureLocation
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

    protected $fillable = ['creature_id', 'location_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Creature, $this>
     */
    public function creature(): BelongsTo
    {
        return $this->belongsTo('App\Models\Creature', 'creature_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Location, $this>
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    public function exportFields(): array
    {
        return ['location_id'];
    }
}
