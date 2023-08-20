<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Campaign;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\TimelineElement;
use App\Services\MultiEditingService;
use Illuminate\Database\Eloquent\Model;

class EditingController extends Controller
{
    protected MultiEditingService $service;

    public function __construct(MultiEditingService $service)
    {
        $this->service = $service;
    }

    private function confirmHandle(Model $model)
    {
        $this->service
            ->user(auth()->user())
            ->model($model)
            ->confirm();

        return response()->json(['success' => true]);
    }

    private function keepAliveHandle(Model $model)
    {
        $this->service->model($model)
            ->user(auth()->user())
            ->keepAlive();

        return response()
            ->json([
                'success' => true
            ]);
    }

    public function confirm(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        return $this->confirmHandle($entity);
    }

    public function confirmCampaign(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return $this->confirmHandle($campaign);
    }

    public function confirmPost(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity->child, 'edit', $post]);

        return $this->confirmHandle($post);
    }

    public function confirmQuestElement(Campaign $campaign, QuestElement $questElement)
    {
        $this->authorize('update', $questElement->quest()->first());

        return $this->confirmHandle($questElement);
    }

    public function confirmTimelineElement(Campaign $campaign, TimelineElement $timelineElement)
    {
        $this->authorize('update', $timelineElement->timeline()->first());

        return $this->confirmHandle($timelineElement);
    }

    public function keepAlive(Campaign $campaign, Entity $entity)
    {
        $this->authorize('update', $entity->child);

        return $this->keepAliveHandle($entity);
    }

    public function keepAliveCampaign(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return $this->keepAliveHandle($campaign);
    }

    public function keepAlivePost(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity->child, 'edit', $post]);

        return $this->keepAliveHandle($post);
    }

    public function keepAliveTimelineElement(Campaign $campaign, TimelineElement $timelineElement)
    {
        $this->authorize('update', $timelineElement->timeline()->first());

        return $this->keepAliveHandle($timelineElement);
    }

    public function keepAliveQuestElement(Campaign $campaign, QuestElement $questElement)
    {
        $this->authorize('update', $questElement->quest()->first());

        return $this->keepAliveHandle($questElement);
    }
}
