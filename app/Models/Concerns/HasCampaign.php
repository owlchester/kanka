<?php

namespace App\Models\Concerns;

use App\Models\Campaign;
use App\Models\Scopes\CampaignScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait HasCampaign
 *
 * @property int $campaign_id
 * @property Campaign $campaign
 *
 * @method static Builder|self allCampaigns()
 */
trait HasCampaign
{
    /** @var bool Determine if the query context is limited to the current campaign */
    protected bool $withCampaignLimit = true;

    public function scopeAllCampaigns(Builder $builder): Builder
    {
        $this->withCampaignLimit = false;

        return $builder;
    }

    /**
     * Check if limited to the current campaign context
     */
    public function withCampaignLimit(): bool
    {
        return $this->withCampaignLimit;
    }

    /**
     * @return void
     */
    public static function bootHasCampaign()
    {
        static::addGlobalScope(new CampaignScope);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Campaign, $this>
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
