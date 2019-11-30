<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Models\Concerns\SimpleSortableTrait;
use App\Traits\VisibleTrait;

/**
 * Class QuestLocation
 * @package App\Models
 * @property integer $location_id
 * @property Location $location
 * @property string $description
 * @property string $role
 * @property string $colour
 * @property integer $impact
 */
class QuestLocation extends QuestElement
{
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
        'colour',
        'impact',
        'is_private'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id');
    }
}
