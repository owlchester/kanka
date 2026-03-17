<?php

namespace App\Http\Controllers\Tags;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Tag;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class TagController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Tag $tag)
    {
        $this->campaign($campaign)->authEntityView($tag->entity);

        return redirect()->route('entities.children', [$campaign, $tag->entity]);
    }
}
