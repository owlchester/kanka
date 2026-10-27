<?php

namespace App\Models\Concerns;

use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ?int $location_id
 * @property ?Location $location
 */
trait HasLocation
{
    /**
     * @return BelongsTo<Location, $this>
     */
    public function location(): BelongsTo
    {
        return $this
            ->belongsTo('App\Models\Location', 'location_id', 'id')
            ->select('locations.id')
            ->with([
                'entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'child_type', 'type_id');
                },
            ]);
    }
}
