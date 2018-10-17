<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\ExportableTrait;
use App\Traits\VisibleTrait;

class Family extends MiscModel
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
        'is_private',
        //'type',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'entry'];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'name',
        'location_id',
        'is_private',
    ];

    /**
     * Foreign relations to add to export
     * @var array
     */
    protected $foreignExport = [
        'members'
    ];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;
    use ExportableTrait;

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'family';

    /**
     * Performance with for datagrids
     * @param $query
     * @return mixed
     */
    public function scopePreparedWith($query)
    {
        return $query->with(['entity', 'location', 'location.entity']);
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
        return $this->hasMany('App\Models\Character', 'family_id', 'id');
    }

    /**
     * Detach children when moving this entity from one campaign to another
     */
    public function detach()
    {
        foreach ($this->members as $child) {
            $child->family_id = null;
            $child->save();
        }

        return parent::detach();
    }
}
