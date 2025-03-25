<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreQuest as Request;
use App\Http\Resources\QuestResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Quest;

class QuestApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection($campaign
            ->quests()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest->entity);

        return new Resource($quest);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.quest')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        /** @var Quest $model */
        $model = Quest::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest->entity);
        $quest->update($request->all());
        $this->crudSave($quest);

        return new Resource($quest);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $quest->entity);
        $quest->delete();

        return response()->json(null, 204);
    }
}
