<?php

namespace App\Models\Concerns;

use App\Facades\CampaignLocalization;
use App\Models\Scopes\PrivateScope;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property bool|int $is_private
 */
trait Privatable
{
    /**
     * Add the Visible scope as a default scope to this model
     */
    public static function bootPrivatable()
    {
        static::addGlobalScope(new PrivateScope);
    }

    public function scopeOnPrivate(Builder $query): Builder
    {
        // Only apply these scopes in non-console mode.
        if (app()->runningInConsole()) {
            return $query;
        }

        // Only admins have access to private models
        $campaign = CampaignLocalization::getCampaign();
        if (auth()->guest() || ! auth()->user()->can('admin', $campaign)) {
            $query->where($this->getTable() . '.is_private', false);
        }

        return $query;
    }
}
