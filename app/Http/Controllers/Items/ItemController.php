<?php

namespace App\Http\Controllers\Items;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Item;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class ItemController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Item $item)
    {
        $this->campaign($campaign)->authEntityView($item->entity);

        return redirect()->route('entities.children', [$campaign, $item->entity]);
    }
}
