<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Organisation;
use App\Models\Campaign;
use App\Models\OrganisationMember;
use App\Http\Requests\StoreOrganisationMember as Request;
use App\Http\Resources\OrganisationMemberResource as Resource;
use App\Http\Resources\OrganisationMemberCollection as Collection;

class OrganisationMemberApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $organisation);
        return Resource::collection($organisation->members()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param OrganisationMember $organisationMember
     * @return Resource
     */
    public function show(Campaign $campaign, Organisation $organisation, OrganisationMember $organisationMember)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $organisation);
        return new Resource($organisationMember);
    }

    /**
     * @param StoreOrganisationMember $reorganisationMember
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $organisation);
        $model = OrganisationMember::create($request->all());
        return new Resource($model);
    }

    /**
     * @param StoreOrganisationMember $reorganisationMember
     * @param Campaign $campaign
     * @param OrganisationMember $organisationMember
     * @return Resource
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Organisation $organisation,
        OrganisationMember $organisationMember
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $organisation);
        $organisationMember->update($request->all());

        return new Resource($organisationMember);
    }

    /**
     * @param Request
     * @param Campaign $campaign
     * @param OrganisationMember $organisationMember
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Organisation $organisation,
        OrganisationMember $organisationMember
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $organisation);
        $organisationMember->delete();

        return response()->json(null, 204);
    }
}
