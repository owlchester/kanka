<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Race;
use App\Http\Requests\StoreRace as Request;
use App\Http\Resources\RaceResource as Resource;

class RaceApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->races()
            ->filter(request()->all())
            ->withApi()
            ->has('entity')
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Race $race)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $race->entity);
        return new Resource($race);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', Race::class);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Race::create($data);
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Race $race)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $race->entity);
        $race->update($request->all());
        $this->crudSave($race);

        return new Resource($race);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Race $race)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $race->entity);
        $race->delete();

        return response()->json(null, 204);
    }
}
