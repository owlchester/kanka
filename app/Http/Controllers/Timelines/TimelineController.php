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

        $options = ['campaign' => $campaign, 'timeline' => $timeline];
        $filters = [];
        if (request()->has('parent_id')) {
            $options['parent_id'] = $timeline->id;
            $filters['timeline_id'] = $timeline->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Timeline\Timeline::class)
            ->route('timelines.timelines', $options);

        $this->rows = $timeline
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity', 'entity.image', 'entity.tags', 'entity.tags.entity',
                'parent', 'parent.entity',
            ])
            ->filter($filters)
            ->paginate();

        if (request()->ajax()) {
            return $this
                ->datagridAjax();
        }

        return $this
            ->subview('timelines.timelines', $timeline);
    }
}
