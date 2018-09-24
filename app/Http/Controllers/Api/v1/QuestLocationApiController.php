<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Quest;
use App\Models\Campaign;
use App\Models\QuestLocation;
use App\Http\Requests\StoreQuestLocation as RequestLocation;
use App\Http\Resources\QuestLocation as Resource;
use App\Http\Resources\QuestLocationCollection as Collection;

class QuestLocationApiController extends ApiController
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
        return new Collection($quest->locations()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param QuestLocation $questLocation
     * @return Resource
     */
    public function show(Campaign $campaign, Quest $quest, QuestLocation $questLocation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest);
        return new Resource($questLocation);
    }

    /**
     * @param RequestLocation $requestLocation
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(RequestLocation $requestLocation, Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $model = QuestLocation::create($requestLocation->all());
        return new Resource($model);
    }

    /**
     * @param RequestLocation $requestLocation
     * @param Campaign $campaign
     * @param QuestLocation $questLocation
     * @return Resource
     */
    public function update(RequestLocation $requestLocation, Campaign $campaign, Quest $quest, QuestLocation $questLocation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questLocation->update($requestLocation->all());

        return new Resource($questLocation);
    }

    /**
     * @param RequestLocation $requestLocation
     * @param Campaign $campaign
     * @param QuestLocation $questLocation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(RequestLocation $requestLocation, Campaign $campaign, Quest $quest, QuestLocation $questLocation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questLocation->delete();

        return response()->json(null, 204);
    }
}
