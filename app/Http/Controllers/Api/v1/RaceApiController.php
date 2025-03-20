<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreRace as Request;
use App\Http\Resources\RaceResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Race;

class RaceApiController extends ApiController
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
            ->races()
            ->filter(request()->all())
            ->withApi()
            ->has('entity')
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Race $race)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $race->entity);

        return new Resource($race);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.race')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Race::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
     * @return resource
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
     *
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
