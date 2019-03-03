<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;
use Kalnoy\Nestedset\NodeTrait;

class Organisation extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'entry',
        'image',
        'location_id',
        'organisation_id',
        'type',
        'is_private',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'entry', 'type'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'organisation';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'type',
        'location_id',
        'organisation_id',
        'tag_id',
        'is_private',
    ];

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'members',
        'quests'
    ];

    /**
     * Nullable values (foreign keys)
     * @var array
     */
    public $nullableForeignKeys = [
        'location_id',
        'organisation_id'
    ];

    /**
     * Traits
     */
    use CampaignTrait, VisibleTrait, ExportableTrait, NodeTrait;

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with(['entity', 'location', 'location.entity', 'organisation']);
    }

    /**
     * Parent
     */
    public function organisation()
    {
        return $this->belongsTo('App\Models\Organisation', 'organisation_id', 'id');
    }

    /**
     * Children
     */
    public function organisations()
    {
        return $this->hasMany('App\Models\Organisation', 'organisation_id', 'id');
    }

    /**
     * @return string
     */
    public function getParentIdName()
    {
        return 'organisation_id';
    }


    /**
     * Specify parent id attribute mutator
     * @param $value
     */
    public function setOrganisationIdAttribute($value)
    {
        $this->setParentIdAttribute($value);
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
    public function members()
    {
        return $this->hasMany('App\Models\OrganisationMember', 'organisation_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quests()
    {
        return $this->hasManyThrough(
            'App\Models\Quest',
            'App\Models\QuestOrganisation',
            'organisation_id',
            'id',
            'id',
            'quest_id');
    }

    /**
     * Get all characters in the organisation and descendants
     */
    public function allMembers()
    {
        $organisationId = [$this->id];
        foreach ($this->descendants as $descendant) {
            $organisationId[] = $descendant->id;
        };

        return OrganisationMember::whereIn('organisation_id', $organisationId)->with('character');
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->children(true)->get() as $child) {
            $child->organisations()->detatch($this->id);
        }
        foreach ($this->members as $child) {
            $child->delete();
        }

        return parent::detach();
    }
}
