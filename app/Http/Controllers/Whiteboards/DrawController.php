<?php

namespace App\Http\Controllers\Whiteboards;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Whiteboard;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class DrawController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function show(Campaign $campaign, Whiteboard $whiteboard)
    {
        $this->campaign($campaign)->authEntityView($whiteboard->entity);

        return view('whiteboards.draw', compact('campaign', 'whiteboard'));
    }
}
