<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;

class DiceRoll extends MiscModel
{
    //
    protected $fillable = [
        'name',
        'slug',
        'campaign_id',
        'character_id',
        'system',
        'parameters',
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
    use ExportableTrait;

    /**
     * Field used for tooltips
     * @var string
     */
    protected $tooltipField = 'name';

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'diceRollResults'
    ];

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diceRollResults()
    {
        return $this->hasMany('App\Models\DiceRollResult', 'dice_roll_id');
    }
}
