<?php

namespace App\Http\Controllers\Maps;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Map;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class MapController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Map $map)
    {
        $this->campaign($campaign)->authEntityView($map->entity);

        return redirect()->route('entities.children', [$campaign, $map->entity]);
    }
}
