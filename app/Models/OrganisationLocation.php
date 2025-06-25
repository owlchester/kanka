<?php

namespace App\Models;

use App\Models\Concerns\Paginatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class OrganisationLocation
 *
 * @property int $organisation_id
 * @property int $location_id
 * @property Organisation $organisation
 * @property Location $location
 */
class OrganisationLocation extends Pivot
{
    use Paginatable;

    /**
     * @var string
     */
    public $table = 'organisation_location';

    protected $fillable = ['organisation_id', 'location_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Organisation, $this>
     */
    public function organisation(): BelongsTo
    {
        return $this->belongsTo('App\Models\Organisation', 'organisation_id', 'id');
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
