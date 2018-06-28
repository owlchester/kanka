<?php

namespace App\Models;

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
        'type',
        'section_id',
        'is_dead',
    ];


    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'title',
        'age',
        'race',
        'sex',
        'location_id',
        'family_id',
        'type',
        'section_id',
        'is_dead',
        'is_private',
    ];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'character';

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'title', 'history'];

    /**
     * Casting for order by
     * @var array
     */
    protected $orderCasting = [
        'age' => 'unsigned'
    ];

    /**
     * Explicit filters
     * @var array
     */
    protected $explicitFilters = [
        'sex'
    ];

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with(['entity', 'location', 'location.entity', 'family', 'family.entity']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function family()
    {
        return $this->belongsTo('App\Models\Family', 'family_id', 'id');
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
    public function quests()
    {
        return $this->hasMany('App\Models\QuestCharacter', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journals()
    {
        return $this->hasMany('App\Models\Journal', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diceRolls()
    {
        return $this->hasMany('App\Models\DiceRoll', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characterTraits()
    {
        return $this->hasMany('App\Models\CharacterTrait', 'character_id', 'id');
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->journals as $child) {
            $child->character_id = null;
            $child->save();
        }

        foreach ($this->items as $child) {
            $child->character_id = null;
            $child->save();
        }

        return parent::detach();
    }
}
