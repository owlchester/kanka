<?php

namespace App\Http\Controllers\Quests;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Quest;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class QuestController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Quest $quest)
    {
        $this->campaign($campaign)->authEntityView($quest->entity);

        return redirect()->route('entities.children', [$campaign, $quest->entity]);
    }
}
