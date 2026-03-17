<?php

namespace App\Http\Controllers\Timelines;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Timeline;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class TimelineController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Timeline $timeline)
    {
        $this->campaign($campaign)->authEntityView($timeline->entity);

        return redirect()->route('entities.children', [$campaign, $timeline->entity]);
    }
}
