<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignGenre
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

    protected $fillable = ['campaign_id', 'genre_id'];

    /**
     * @return BelongsTo<Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo('App\Models\Campaign', 'campaign_id', 'id');
    }

    /**
     * @return BelongsTo<Genre, $this>
     */
    public function genre(): BelongsTo
    {
        return $this->belongsTo('App\Models\Genre', 'genre_id', 'id');
    }
}
