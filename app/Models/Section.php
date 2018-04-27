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
        foreach ($this->allChildren(true)->get() as $child) {
            if (!empty($child->child)) {
                $child->child->section_id = null;
                $child->child->save();
            }
        }
        return parent::detach();
    }

    /**
     * Get all the children
     * @return array
     */
    public function allChildren($withSections = false)
    {
        $sectionIds = [$this->id];
        foreach ($this->descendants as $desc) {
            $sectionIds[] = $desc->id;
        }
        if ($withSections) {
            return Entity::whereIn('section_id', $sectionIds);
        }
        return Entity::whereIn('section_id', $sectionIds)->whereNotIn('type', ['section']);
    }
}
