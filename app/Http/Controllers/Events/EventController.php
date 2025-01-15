<?php

namespace App\Http\Controllers\Events;

use App\Facades\Datagrid;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Event;
use App\Traits\CampaignAware;
use App\Traits\Controllers\HasDatagrid;
use App\Traits\Controllers\HasSubview;
use App\Traits\GuestAuthTrait;

class EventController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;
    use HasDatagrid;
    use HasSubview;

    public function index(Campaign $campaign, Event $event)
    {
        $this->campaign($campaign)->authEntityView($event->entity);

        $options = ['campaign' => $campaign, 'event' => $event, 'm' => $this->descendantsMode()];
        $filters = [];
        if ($this->filterToDirect()) {
            $filters['event_id'] = $event->id;
        }
        Datagrid::layout(\App\Renderers\Layouts\Event\Event::class)
            ->route('events.events', $options);

        //@phpstan-ignore-next-line
        $this->rows = $event
            ->descendants()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with([
                'entity', 'entity.image', 'entity.entityType', 'entity.tags', 'entity.tags.entity',
                'parent', 'parent.entity'
            ])
            ->has('entity')
            ->filter($filters)
            ->paginate();

        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->subview('events.events', $event);
    }
}
