<?php

namespace App\Observers;

use App\Campaign;
use App\Facades\CampaignLocalization;
use App\Models\Relation;
use App\Traits\RelationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class RelationObserver
{
    public function creating(Relation $relation)
    {
        $relation->campaign_id = CampaignLocalization::getCampaign()->id;

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($relation->is_private)) {
            $relation->is_private = false;
        }
    }

    public function created(Relation $relation)
    {
        if (request()->has('two_way')) {
            // Make sure we're not creating an infinite loop
            $data = [
                'owner_id' => $relation->target_id,
                'target_id' => $relation->owner_id,
                'campaign_id' => $relation->campaign_id,
                'relation' => $relation->relation,
                'is_private' => $relation->is_private,
            ];
            $reverse = Relation::where($data)->first();
            if (empty($reverse)) {
                // Create reverse
                $r = new Relation();
                $r->create($data);
            }
        }
    }
}
