<?php

namespace App\Models;

use App\Traits\VisibleTrait;

class QuestLocation extends MiscModel
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
    protected $fillable = ['quest_id', 'location_id', 'description', 'is_private'];

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
