<?php

namespace App;

use App\Scopes\CampaignScope;

class Organisation extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'history', 'image', 'location_id', 'type'];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CampaignScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany('App\OrganisationMember', 'organisation_id', 'id');
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
