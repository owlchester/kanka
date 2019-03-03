<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;

class Item extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'campaign_id',
        'slug',
        'type',
        'image',
        'entry',
        'character_id',
        'location_id',
        'is_private',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type', 'entry'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'item';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'location_id',
        'character_id',
        'tag_id',
        'is_private',
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'location_id',
        'character_id',
    ];


    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'quests',
    ];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
    use ExportableTrait;

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with(['entity', 'location', 'location.entity', 'character', 'character.entity']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character', 'character_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Models\Location', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quests()
    {
        return $this->hasManyThrough(
            'App\Models\Quest',
            'App\Models\QuestItem',
            'item_id',
            'id',
            'id',
            'quest_id');
    }
}
