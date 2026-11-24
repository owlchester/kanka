<?php

namespace App\Models;

use App\Facades\Mentions;
use App\Observers\CampaignDescriptionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $campaign_id
 * @property ?string $description
 * @property ?string $excerpt
 * @property Campaign $campaign
 */
#[ObservedBy(CampaignDescriptionObserver::class)]
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

    public function getDescriptionForEditionAttribute(): string
    {
        return Mentions::parseForEdit($this, 'description');
    }
}
