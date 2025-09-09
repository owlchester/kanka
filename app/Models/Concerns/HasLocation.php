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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Location, $this>
     */
    public function location(): BelongsTo
    {
        return $this
            ->belongsTo('App\Models\Location', 'location_id', 'id')
            ->select('locations.id', 'locations.name')
            ->with([
                'entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
            ]);
    }
}
