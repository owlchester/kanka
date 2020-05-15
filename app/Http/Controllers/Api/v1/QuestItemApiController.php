<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Quest;
use App\Models\Campaign;
use App\Models\QuestItem;
use App\Http\Requests\StoreQuestItem as RequestItem;
use App\Http\Resources\QuestItemResource as Resource;
use App\Http\Resources\QuestItemCollection as Collection;

class QuestItemApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest);
        return Resource::collection($quest->items()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param QuestItem $questItem
     * @return Resource
     */
    public function show(Campaign $campaign, Quest $quest, QuestItem $questItem)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest);
        return new Resource($questItem);
    }

    /**
     * @param RequestItem $requestItem
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(RequestItem $requestItem, Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $model = QuestItem::create($requestItem->all());
        return new Resource($model);
    }

    /**
     * @param RequestItem $requestItem
     * @param Campaign $campaign
     * @param QuestItem $questItem
     * @return Resource
     */
    public function update(RequestItem $requestItem, Campaign $campaign, Quest $quest, QuestItem $questItem)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questItem->update($requestItem->all());

        return new Resource($questItem);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Campaign $campaign
     * @param QuestItem $questItem
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Quest $quest,
        QuestItem $questItem
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questItem->delete();

        return response()->json(null, 204);
    }
}
