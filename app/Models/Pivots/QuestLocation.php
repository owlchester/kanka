<?php

namespace App\Models\Pivots;

use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class QuestLocation
 * @package App\Models
 * @property integer $location_id
 * @property Location $location
 * @property string $description
 * @property string $role
 */
class QuestLocation extends Pivot
{
    /**
     * Traits
     */
    use VisibleTrait;

    /**
     * ACL Trait config
     * Tell the ACL trait that we aren't looking on this model but on locations.
     */
    public $entityType = 'location';
    public $aclFieldName = 'location_id';

    /**
     * @var string
     */
    public $table = 'quest_locations';

    /**
     * @var array
     */
    protected $fillable = [
        'quest_id',
        'location_id',
        'description',
        'role',
        'is_private'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quest()
    {
        return $this->belongsTo('App\Models\Quest', 'quest_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }
}
