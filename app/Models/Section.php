<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;
use Kalnoy\Nestedset\NodeTrait;

class Section extends MiscModel
{
    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type', 'description'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'section';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = ['name', 'type', 'section_id'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'image',
        'description',
        'section_id',
        'campaign_id',
        'is_private',
    ];

    /**
     * Field used for tooltips
     * @var string
     */
    protected $tooltipField = 'description';

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
    use NodeTrait;

    /**
     * Parent
     */
    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id', 'id');
    }

    /**
     * Children
     */
    public function sections()
    {
        return $this->hasMany('App\Models\Section', 'section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters()
    {
        return $this->hasMany('App\Models\Character', 'section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany('App\Models\Location', 'section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany('App\Models\Note', 'section_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function families()
    {
        return $this->hasMany('App\Models\Family', 'section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\Organisation', 'section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item', 'section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event', 'section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quests()
    {
        return $this->hasMany('App\Models\Quest', 'section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calendars()
    {
        return $this->hasMany('App\Models\Calendar', 'section_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function journals()
    {
        return $this->hasMany('App\Models\Journal', 'section_id', 'id');
    }

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'section_id';
    }

    /**
     * Specify parent id attribute mutator
     * @param $value
     */
    public function setSectionIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->characters as $child) {
            $child->section_id = null;
            $child->save();
        }

        foreach ($this->locations as $child) {
            $child->section_id = null;
            $child->save();
        }

        foreach ($this->organisations as $child) {
            $child->section_id = null;
            $child->save();
        }

        foreach ($this->families as $child) {
            $child->section_id = null;
            $child->save();
        }

        foreach ($this->items as $child) {
            $child->section_id = null;
            $child->save();
        }

        foreach ($this->notes as $child) {
            $child->section_id = null;
            $child->save();
        }

        foreach ($this->sections as $child) {
            $child->section_id = null;
            $child->save();
        }

        return parent::detach();
    }

    /**
     * Get all the children
     * @return array
     */
    public function allChildren()
    {
        $all = [];
        foreach ($this->characters as $model) {
            $all[] = $model;
        }
        foreach ($this->locations as $model) {
            $all[] = $model;
        }
        foreach ($this->notes as $model) {
            $all[] = $model;
        }
        foreach ($this->families as $model) {
            $all[] = $model;
        }
        foreach ($this->organisations as $model) {
            $all[] = $model;
        }
        foreach ($this->items as $model) {
            $all[] = $model;
        }
        foreach ($this->events as $model) {
            $all[] = $model;
        }
        foreach ($this->quests as $model) {
            $all[] = $model;
        }
        foreach ($this->calendars as $model) {
            $all[] = $model;
        }
        foreach ($this->journals as $model) {
            $all[] = $model;
        }
        return $all;
    }
}
