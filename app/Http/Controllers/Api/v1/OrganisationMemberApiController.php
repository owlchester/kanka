<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreOrganisationMember as Request;
use App\Http\Resources\OrganisationMemberResource as Resource;
use App\Models\Campaign;
use App\Models\Organisation;
use App\Models\OrganisationMember;

class OrganisationMemberApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $organisation->entity);

        return Resource::collection($organisation->members()->has('character')->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Organisation $organisation, OrganisationMember $organisationMember)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $organisation->entity);

        return new Resource($organisationMember);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $organisation->entity);
        $model = OrganisationMember::create($request->all());

        return new Resource($model);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(
        Request $request,
        Campaign $campaign,
        Organisation $organisation,
        OrganisationMember $organisationMember
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $organisation->entity);
        $organisationMember->update($request->all());

        return new Resource($organisationMember);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Organisation $organisation,
        OrganisationMember $organisationMember
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $organisation->entity);
        $organisationMember->delete();

        return response()->json(null, 204);
    }
}
