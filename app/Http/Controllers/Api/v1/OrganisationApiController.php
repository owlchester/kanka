<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreOrganisation as Request;
use App\Http\Resources\OrganisationResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Organisation;

class OrganisationApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection($campaign
            ->organisations()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $organisation->entity);

        return new Resource($organisation);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.organisation')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Organisation::create($data);
        $this->crudSave($model);
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $organisation->entity);
        $organisation->update($request->all());
        $this->crudSave($organisation);

        return new Resource($organisation);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Organisation $organisation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $organisation->entity);
        $organisation->delete();

        return response()->json(null, 204);
    }
}
