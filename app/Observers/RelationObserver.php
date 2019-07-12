<?php

namespace App\Observers;

use App\Facades\CampaignLocalization;
use App\Models\Relation;

class RelationObserver
{
    /**
     * @param Relation $relation
     */
    public function creating(Relation $relation)
    {
        $relation->campaign_id = CampaignLocalization::getCampaign()->id;
    }
}
