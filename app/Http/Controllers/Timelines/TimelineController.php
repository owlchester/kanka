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

        $options = ['campaign' => $campaign, 'timeline' => $timeline, 'm' => $this->descendantsMode()];
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['timeline_id'] = $timeline->id;
        }

        Datagrid::layout(\App\Renderers\Layouts\Timeline\Timeline::class)
            ->route('timelines.timelines', $options);

        // @phpstan-ignore-next-line
        $this->rows = $timeline
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity', 'entity.image', 'entity.entityType', 'entity.visibleTags',
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
