<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;

class DiceRoll extends MiscModel
{
    //
    protected $fillable = [
        'name',
        'slug',
        'campaign_id',
        'user_id',
        'character_id',
        'system',
        'parameters',
        'results',
        'is_private',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'user_id',
        'character_id',
        'is_private',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'dice_roll';

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;

    /**
     * Field used for tooltips
     * @var string
     */
    protected $tooltipField = 'name';

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }
}
