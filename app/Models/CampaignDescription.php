<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $campaign_id
 * @property ?string $description
 * @property ?string $excerpt
 * @property Campaign $campaign
 */
class CampaignDescription extends Model
{
    protected $fillable = [
        'campaign_id',
        'description',
        'excerpt',
    ];

    /**
     * @return BelongsTo<Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
