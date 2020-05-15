<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Organisation;
use App\Http\Requests\StoreOrganisation as Request;
use App\Http\Resources\OrganisationResource as Resource;
use App\Http\Resources\OrganisationCollection as Collection;

class OrganisationApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->organisations()
            ->with(['entity', 'entity.tags', 'entity.notes', 'entity.files', 'entity.events',
                'entity.relationships', 'entity.attributes'])
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Organisation $organisation
     * @return Resource
     */
    public function show(Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $organisation);
        return new Resource($organisation);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', Organisation::class);
        $model = Organisation::create($request->all());
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Organisation $organisation
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $organisation);
        $organisation->update($request->all());
        $this->crudSave($organisation);

        return new Resource($organisation);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Organisation $organisation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $organisation);
        $organisation->delete();

        return response()->json(null, 204);
    }
}
