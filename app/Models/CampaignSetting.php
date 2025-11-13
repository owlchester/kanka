<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Campaign $campaign
 *
 * @property int|bool $characters
 * @property int|bool $quests
 * @property int|bool $events
 * @property int|bool $dice_rolls
 * @property int|bool $conversations
 * @property int|bool $abilities
 * @property int|bool $calendars
 * @property int|bool $items
 * @property int|bool $timelines
 * @property int|bool $races
 */
class CampaignSetting extends Model
{
    /**
     * @var string
     */
    public $table = 'campaign_settings';

    protected $fillable = [
        'abilities',
        'assets',
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
        'whiteboards',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Campaign, $this>
     */
    public function campaign(): BelongsTo
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
