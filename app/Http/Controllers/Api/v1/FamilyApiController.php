<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Family;
use App\Http\Requests\StoreFamily as Request;
use App\Http\Resources\FamilyResource as Resource;

class FamilyApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->families()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $family->entity);
        return new Resource($family);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.family')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Family::create($data);
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $family->entity);
        $family->update($request->all());
        $this->crudSave($family);

        return new Resource($family);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Family $family)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $family->entity);
        $family->delete();

        return response()->json(null, 204);
    }
}
