<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignGenre
 * @package App\Models
 *
 * @property int $genre_id
 * @property int $campaign_id
 * @property Campaign $campaign
 * @property Genre $genre
 */
class CampaignGenre extends Pivot
{
    /**
     * @var string
     */
    public $table = 'campaign_genre';

    /** @var string[]  */
    protected $fillable = ['campaign_id', 'genre_id'];

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
    public function genre()
    {
        return $this->belongsTo('App\Models\Genre', 'genre_id', 'id');
    }
}
