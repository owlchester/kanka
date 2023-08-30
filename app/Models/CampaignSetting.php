<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignSetting extends Model
{
    /**
     * @var string
     */
    public $table = 'campaign_settings';

    /** @var string[]  */
    protected $fillable = [
        'abilities',
        'campaign_id',
        'characters',
        'entity_attributes',
        'events',
        'families',
        'items',
        'journals',
        'locations',
        'notes',
        'organisations',
        'quests',
        'calendars',
        'tags',
        'dice_rolls',
        'bookmarks',
        'conversations',
        'races',
        'maps',
        'timelines',
        'inventories',
        'creatures',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * Count the number of activated modules
     */
    public function countEnabledModules(): int
    {
        $count = 0;
        foreach ($this->fillable as $col) {
            if ($col != 'campaign_id' && $this->$col == true) {
                $count++;
            }
        }

        return $count;
    }
}
