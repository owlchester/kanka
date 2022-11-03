<?php


namespace App\Http\Controllers\Entity;


use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\Campaign;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Services\Entity\MultiEditingService;
use Ramsey\Uuid\Type\Time;

class EditingController extends Controller
{
    /** @var MultiEditingService */
    protected $service;

    public function __construct(MultiEditingService $service)
    {
        $this->service = $service;
    }

    public function confirm(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $this->service->model($entity)
            ->user(auth()->user());

        if (!$this->service->isEditing()) {
            $this->service->edit();
        }

        return response()
            ->json([
                'success' => true
            ]);
    }

    public function confirmCampaign(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $this->service
            ->user(auth()->user())
            ->model($campaign)
            ->confirm();

        return response()->json(['success' => true]);
    }

    public function confirmPost(Entity $entity, EntityNote $entityNote)
    {
        $this->authorize('entity-note', [$entity->child, 'edit', $entityNote]);

        $this->service
            ->user(auth()->user())
            ->model($entityNote)
            ->confirm();

        return response()->json(['success' => true]);
    }

    public function confirmQuestElement(QuestElement $questElement)
    {
        $this->authorize('update', $questElement->quest()->first());

        $this->service
            ->user(auth()->user())
            ->model($questElement)
            ->confirm();

        return response()->json(['success' => true]);
    }

    public function confirmTimelineElement(TimelineElement $timelineElement)
    {
        $this->authorize('update', $timelineElement->timeline()->first());

        $this->service
            ->user(auth()->user())
            ->model($timelineElement)
            ->confirm();

        return response()->json(['success' => true]);
    }

    public function keepAlive(Entity $entity)
    {
        $this->authorize('update', $entity->child);

        $this->service->model($entity)
            ->user(auth()->user())
            ->keepAlive();

        return response()
            ->json([
                'success' => true
            ]);
    }

    public function keepAliveCampaign(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $this->service->model($campaign)
            ->user(auth()->user())
            ->keepAlive();

        return response()
            ->json([
                'success' => true
            ]);
    }

    public function keepAlivePost(Entity $entity, EntityNote $entityNote)
    {
        $this->authorize('entity-note', [$entity->child, 'edit', $entityNote]);

        $this->service->model($entityNote)
            ->user(auth()->user())
            ->keepAlive();

        return response()
            ->json([
                'success' => true
            ]);
    }

    public function keepAliveTimelineElement(TimelineElement $timelineElement)
    {
        $this->authorize('update', $timelineElement->timeline()->first());

        $this->service->model($timelineElement)
            ->user(auth()->user())
            ->keepAlive();

        return response()
            ->json([
                'success' => true
            ]);
    }

    public function keepAliveQuestElement(QuestElement $questElement)
    {
        $this->authorize('update', $questElement->quest()->first());

        $this->service->model($questElement)
            ->user(auth()->user())
            ->keepAlive();

        return response()
            ->json([
                'success' => true
            ]);
    }
}
