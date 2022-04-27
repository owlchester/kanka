<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Facades\CampaignLocalization;

class CampaignScope implements Scope
{
    /**
     * @param Builder $builder
     * @param Model $model
     * @return Builder
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!app()->runningInConsole()) {
            $campaign = CampaignLocalization::getCampaign();
            if ($campaign) {
                $builder->where($model->getTable() . '.campaign_id', '=', $campaign->id);
            }
            return $builder;
        }

        // In console mode, we still sometimes need scoping to a campaign (for example when deleting nested
        // elements to not interfere with data from other campaigns.
        $campaignId = CampaignLocalization::getConsoleCampaign();
        if ($campaignId && $model->withCampaignLimit()) {
            $builder->where($model->getTable() . '.campaign_id', '=', $campaignId);
        }
        return $builder;
    }
}
