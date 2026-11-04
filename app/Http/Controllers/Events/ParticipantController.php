<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventGroup;
use App\Http\Requests\StoreEventParticipant;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Event;
use App\Models\EventGroup;
use App\Models\EventParticipant;
use App\Services\Events\ParticipantService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Validation\ValidationException;

class ParticipantController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(private ParticipantService $service) {}

    public function index(Campaign $campaign, Event $event)
    {
        abort_unless($event->campaign_id === $campaign->id, 404);
        $this->campaign($campaign)->authEntityView($event->entity);

        $entity = $event->entity;
        $model = $event;
        $participantState = $this->service->state($event);

        return view('events.participants', compact('campaign', 'event', 'entity', 'model', 'participantState'));
    }

    public function store(StoreEventParticipant $request, Campaign $campaign, Event $event)
    {
        abort_unless($event->campaign_id === $campaign->id, 404);
        $this->authorize('update', $event->entity);
        $data = $request->validated();
        $entity = Entity::findOrFail($data['entity_id']);
        $this->authorize('view', $entity);

        if (! empty($data['group_id']) && ! $event->groups()->whereKey($data['group_id'])->exists()) {
            throw ValidationException::withMessages(['group_id' => __('validation.exists', ['attribute' => 'group'])]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        $event->participants()->create($data + ['position' => (int) $event->participants()->max('position') + 1]);

        return redirect()->route('events.participants.index', [$campaign, $event]);
    }

    public function destroy(Campaign $campaign, Event $event, EventParticipant $participant)
    {
        abort_unless($event->campaign_id === $campaign->id, 404);
        $this->authorize('update', $event->entity);
        abort_unless($participant->event_id === $event->id, 404);
        $participant->delete();

        return redirect()->route('events.participants.index', [$campaign, $event]);
    }

    public function storeGroup(StoreEventGroup $request, Campaign $campaign, Event $event)
    {
        abort_unless($event->campaign_id === $campaign->id, 404);
        $this->authorize('update', $event->entity);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        $event->groups()->create($request->validated() + ['position' => (int) $event->groups()->max('position') + 1]);

        return redirect()->route('events.participants.index', [$campaign, $event]);
    }

    public function destroyGroup(Campaign $campaign, Event $event, EventGroup $group)
    {
        abort_unless($event->campaign_id === $campaign->id, 404);
        $this->authorize('update', $event->entity);
        abort_unless($group->event_id === $event->id, 404);
        $group->participants()->update(['group_id' => null]);
        $group->delete();

        return redirect()->route('events.participants.index', [$campaign, $event]);
    }
}
