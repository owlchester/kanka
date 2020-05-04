<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;
use App\Facades\CampaignLocalization;

class CampaignScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!app()->runningInConsole()) {
            $campaign = CampaignLocalization::getCampaign();
            if ($campaign) {
                $builder->where($model->getTable() . '.campaign_id', '=', $campaign->id);
            }
        } else {
            // In console mode, we still sometimes need scoping to a campaign (for example when deleting nested
            // elements to not interfere with data from other campaigns.
            $campaignId = CampaignLocalization::getConsoleCampaign();
            if ($campaignId) {
                $builder->where($model->getTable() . '.campaign_id', '=', $campaignId);
            }
        }
    }
}
