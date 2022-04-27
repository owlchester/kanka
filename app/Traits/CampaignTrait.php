<?php

namespace App\Traits;

use App\Models\Scopes\CampaignScope;
use Illuminate\Database\Query\Builder;

/**
 * Trait CampaignTrait
 * @package App\Traits
 *
 * @method static Builder|self allCampaigns()
 */
trait CampaignTrait
{
    protected $withCampaignLimit = true;

    public function scopeAllCampaigns($builder)
    {
        $this->withCampaignLimit = false;
        return $builder;
    }

    public function withCampaignLimit(): bool
    {
        return $this->withCampaignLimit;
    }

    public static function bootCampaignTrait()
    {
        static::addGlobalScope(new CampaignScope());
    }
}
