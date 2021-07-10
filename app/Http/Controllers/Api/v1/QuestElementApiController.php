<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Quest;
use App\Models\Campaign;
use App\Models\QuestElement;
use App\Http\Requests\StoreQuestElement as RequestElement;
use App\Http\Resources\QuestElementResource as Resource;
use App\Http\Resources\QuestElementCollection as Collection;

class QuestElementApiController extends ApiController
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
        return Resource::collection($quest->elements()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param QuestElement $questElement
     * @return Resource
     */
    public function show(Campaign $campaign, Quest $quest, QuestElement $questElement)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest);
        return new Resource($questElement);
    }

    /**
     * @param RequestElement $requestElement
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(RequestElement $requestElement, Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $data = $requestElement->all();
        $data['quest_id'] = $quest->id;
        $model = QuestElement::create($data);
        return new Resource($model);
    }

    /**
     * @param RequestElement $requestElement
     * @param Campaign $campaign
     * @param QuestElement $questElement
     * @return Resource
     */
    public function update(
        RequestElement $requestElement,
        Campaign $campaign,
        Quest $quest,
        QuestElement $questElement
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questElement->update($requestElement->all());

        return new Resource($questElement);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Campaign $campaign
     * @param QuestElement $questElement
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Quest $quest,
        QuestElement $questElement
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questElement->delete();

        return response()->json(null, 204);
    }
}
