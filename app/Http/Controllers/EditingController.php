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

    public function index(Campaign $campaign)
    {
        $model = request()->get('model');
        $id = request()->get('id');
        if (empty($model)) {
            $model = $campaign;
        } else {
            $modelName = app()->make('App\Models\\' . $model);
            $model = new $modelName();
            $model = $model->findOrFail($id);
        }

        $editingUsers = $this->service
            ->model($model)
            ->user(auth()->user())
            ->users();

        if ($model instanceof Post) {
            $url = route('posts.confirm-editing', [$campaign, 'post' => $model, 'entity' => $model->entity]);
            $show = $model->entity->url();
        } elseif ($model instanceof Campaign) {
            $url = route('campaigns.confirm-editing', $model);
            $show = route('overview', $campaign);
        } elseif ($model instanceof TimelineElement) {
            $url = route('timeline-elements.confirm-editing', [$campaign, $model]);
            $show = $model->timeline->getLink();
        } elseif ($model instanceof QuestElement) {
            $url = route('quest-elements.confirm-editing', [$campaign, $model]);
            $show = $model->quest->getLink();
        } else {
            $url = route('entities.confirm-editing', [$campaign, $model]);
            $show = $model->url();
        }

        return view('confirms.editing')
            ->with('url', $url)
            ->with('show', $show)
            ->with('editingUsers', $editingUsers);
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
        $this->authorize('update', $entity);

        return $this->confirmHandle($entity);
    }

    public function confirmCampaign(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return $this->confirmHandle($campaign);
    }

    public function confirmPost(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity, 'edit', $post]);

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
        $this->authorize('update', $entity);

        return $this->keepAliveHandle($entity);
    }

    public function keepAliveCampaign(Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        return $this->keepAliveHandle($campaign);
    }

    public function keepAlivePost(Campaign $campaign, Entity $entity, Post $post)
    {
        $this->authorize('post', [$entity, 'edit', $post]);

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
