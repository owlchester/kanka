<?php

namespace App;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;
use Stevebauman\Purify\Facades\Purify;

class Character extends MiscModel
{
    //
    protected $fillable = [
        'name',
        'slug',
        'campaign_id',
        'family_id',
        'location_id',
        'title',
        'history',
        'age',
        'height',
        'weight',
        'sex',
        'race',
        'eye_colour',
        'hair',
        'skin',
        'image',
        'traits',
        'goals',
        'fears',
        'mannerisms',
        'languages',
        'free',
        'is_private',
        'is_personality_visible',
    ];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'title', 'race', 'sex'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family()
    {
        return $this->belongsTo('App\Family', 'family_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationships()
    {
        return $this->hasMany('App\Models\CharacterRelation', 'first_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\OrganisationMember', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Item', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany('App\Models\CharacterAttribute', 'character_id', 'id');
    }

    /**
     * Get a short history/description for the dashboard
     * @param int $limit
     * @return string
     */
    public function shortHistory($limit = 150)
    {
        $pureHistory = strip_tags($this->history);
        if (!empty($pureHistory)) {
            if (strlen($pureHistory) > $limit) {
                return substr($pureHistory, 0, $limit) . '...';
            }
        }
        return $pureHistory;
    }
}
