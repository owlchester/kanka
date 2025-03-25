<?php

namespace App\Http\Controllers\Entity\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Inventory;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class DetailController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function index(Campaign $campaign, Entity $entity, Inventory $inventory)
    {
        $this->campaign($campaign)->authEntityView($entity);
        if ($inventory->item_id && ! $inventory->item) {
            abort(403);
        }

        return view('entities.pages.inventory.details')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('inventory', $inventory);
    }
}
