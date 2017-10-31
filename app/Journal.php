<?php

namespace App;

use App\Scopes\CampaignScope;

class Journal extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'campaign_id', 'slug', 'type', 'image', 'history', 'date'];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns  = ['name', 'type'];

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
     * Get a short history/description for the dashboard
     * @param int $limit
     * @return string
     */
    public function shortHistory($limit = 250)
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
