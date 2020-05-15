<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Quest;
use App\Models\Campaign;
use App\Models\QuestCharacter;
use App\Http\Requests\StoreQuestCharacter as RequestCharacter;
use App\Http\Resources\QuestCharacterResource as Resource;
use App\Http\Resources\QuestCharacterCollection as Collection;

class QuestCharacterApiController extends ApiController
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
        return Resource::collection($quest->characters()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param QuestCharacter $questCharacter
     * @return Resource
     */
    public function show(Campaign $campaign, Quest $quest, QuestCharacter $questCharacter)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest);
        return new Resource($questCharacter);
    }

    /**
     * @param RequestCharacter $requestCharacter
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(RequestCharacter $requestCharacter, Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $model = QuestCharacter::create($requestCharacter->all());
        return new Resource($model);
    }

    /**
     * @param RequestCharacter $requestCharacter
     * @param Campaign $campaign
     * @param QuestCharacter $questCharacter
     * @return Resource
     */
    public function update(
        RequestCharacter $requestCharacter,
        Campaign $campaign,
        Quest $quest,
        QuestCharacter $questCharacter
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questCharacter->update($requestCharacter->all());

        return new Resource($questCharacter);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Campaign $campaign
     * @param QuestCharacter $questCharacter
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Quest $quest,
        QuestCharacter $questCharacter
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questCharacter->delete();

        return response()->json(null, 204);
    }
}
