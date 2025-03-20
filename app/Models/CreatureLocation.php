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

    public function creature(): BelongsTo
    {
        return $this->belongsTo('App\Models\Creature', 'creature_id', 'id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    public function exportFields(): array
    {
        return ['location_id'];
    }
}
