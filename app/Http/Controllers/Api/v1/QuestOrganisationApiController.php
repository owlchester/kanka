<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Quest;
use App\Models\Campaign;
use App\Models\QuestOrganisation;
use App\Http\Requests\StoreQuestOrganisation as RequestOrganisation;
use App\Http\Resources\QuestOrganisationResource as Resource;
use App\Http\Resources\QuestOrganisationCollection as Collection;

class QuestOrganisationApiController extends ApiController
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
        return Resource::collection($quest->organisations()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param QuestOrganisation $questOrganisation
     * @return Resource
     */
    public function show(Campaign $campaign, Quest $quest, QuestOrganisation $questOrganisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest);
        return new Resource($questOrganisation);
    }

    /**
     * @param RequestOrganisation $requestOrganisation
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(RequestOrganisation $requestOrganisation, Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $model = QuestOrganisation::create($requestOrganisation->all());
        return new Resource($model);
    }

    /**
     * @param RequestOrganisation $requestOrganisation
     * @param Campaign $campaign
     * @param QuestOrganisation $questOrganisation
     * @return Resource
     */
    public function update(
        RequestOrganisation $requestOrganisation,
        Campaign $campaign,
        Quest $quest,
        QuestOrganisation $questOrganisation
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questOrganisation->update($requestOrganisation->all());

        return new Resource($questOrganisation);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Campaign $campaign
     * @param QuestOrganisation $questOrganisation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Quest $quest,
        QuestOrganisation $questOrganisation
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest);
        $questOrganisation->delete();

        return response()->json(null, 204);
    }
}
