<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreOrganisationMember as Request;
use App\Http\Resources\OrganisationMemberResource as Resource;
use App\Models\Campaign;
use App\Models\Organisation;
use App\Models\OrganisationMember;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganisationMemberApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
     * @throws AuthorizationException
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
     * @throws AuthorizationException
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
     * @return JsonResponse
     *
     * @throws AuthorizationException
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
