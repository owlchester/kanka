<?php

namespace App\Http\Controllers\Races;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Race;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class RaceController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Race $race)
    {
        $this->campaign($campaign)->authEntityView($race->entity);

        return redirect()->route('entities.children', [$campaign, $race->entity]);
    }
}
