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
    public function location(): BelongsTo
    {
        return $this
            ->belongsTo('App\Models\Location', 'location_id', 'id')
            ->with([
                'entity' => function ($sub) {
                    $sub->select('id', 'name', 'entity_id', 'type_id');
                },
            ]);
    }
}
