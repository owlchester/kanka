<?php

namespace App\Models\Scopes;

use App\Facades\CampaignLocalization;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;

class CampaignScope implements Scope
{
    /**
     * @param  Location  $model
     * @return Builder
     */
    public function apply(Builder $builder, $model)
    {
        if (! app()->runningInConsole()) {
            $campaign = CampaignLocalization::getCampaign();
            if ($campaign && $model->withCampaignLimit()) {
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
