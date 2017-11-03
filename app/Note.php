<?php

namespace App;

use App\Scopes\CampaignScope;

class Note extends MiscModel
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'description', 'image', 'type'];

    /**
     * Searchable fields
     * @var array
     */
    protected $searchableColumns = ['name', 'type'];

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
    public function shortHistory($limit = 150)
    {
        $pureHistory = strip_tags($this->description);
        if (!empty($pureHistory)) {
            if (strlen($pureHistory) > $limit) {
                return substr($pureHistory, 0, $limit) . '...';
            }
        }
        return $pureHistory;
    }
}
