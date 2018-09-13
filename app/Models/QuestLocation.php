<?php

namespace App\Models;

use App\Models\MiscModel;
use App\Traits\VisibleTrait;

class QuestLocation extends MiscModel
{
    /**
     * Traits
     */
    use VisibleTrait;

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
