<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;

class Organisation extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'history',
        'image',
        'location_id',
        'type',
        'is_private',
    ];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'history', 'type'];

    /**
     * Entity type
     * @var string
     */
    protected $entityType = 'organisation';

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = ['name', 'type', 'location_id'];

    /**
     * Traits
     */
    use CampaignTrait;
    use VisibleTrait;

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
    public function relationships()
    {
        return $this->hasMany('App\Models\OrganisationRelation', 'first_id', 'id');
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
