<?php

namespace App\Models;

use App\Models\MiscModel;
use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;

class Quest extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'quest_id',
        'name',
        'slug',
        'type',
        'description',
        'is_private',
        'section_id',
        'character_id',
        'is_completed',
    ];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'quest';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'quest_id',
        'section_id',
        'character_id',
        'is_completed',
        'is_private',
    ];

    /**
     * Field used for tooltip (default is history)
     * @var string
     */
    protected $tooltipField = 'description';

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
    use ExportableTrait;

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type', 'description'];

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'locations',
        'characters',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quest()
    {
        return $this->belongsTo('App\Models\Quest', 'quest_id', 'id');
    }

    /**
     * @return mixed
     */
    public function shortDescription()
    {
        return $this->name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locations()
    {
        return $this->hasMany('App\Models\QuestLocation', 'quest_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function characters()
    {
        return $this->hasMany('App\Models\QuestCharacter', 'quest_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quests()
    {
        return $this->hasMany('App\Models\Quest', 'quest_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character');
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->locations as $child) {
            $child->delete();
        }
        foreach ($this->characters as $child) {
            $child->delete();
        }
        foreach ($this->quests as $quest) {
            $quest->quest_id = null;
            $quest->save();
        }
        return parent::detach();
    }
}
