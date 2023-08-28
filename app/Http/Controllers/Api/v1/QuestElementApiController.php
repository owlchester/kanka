<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Quest;
use App\Models\Campaign;
use App\Models\QuestElement;
use App\Http\Requests\StoreQuestElement as RequestElement;
use App\Http\Resources\QuestElementResource as Resource;

class QuestElementApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest);
        return Resource::collection($quest->elements()->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Quest $quest, QuestElement $questElement)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest);
        return new Resource($questElement);
    }

    /**
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
