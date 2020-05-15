<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Item;
use App\Http\Requests\StoreItem as Request;
use App\Http\Resources\ItemResource as Resource;

class ItemApiController extends ApiController
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
            ->items()
            ->with(['entity', 'entity.tags', 'entity.notes', 'entity.files',
                'entity.events', 'entity.relationships', 'entity.attributes'])
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Item $item
     * @return Resource
     */
    public function show(Campaign $campaign, Item $item)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $item);
        return new Resource($item);
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
        $this->authorize('create', Item::class);
        $model = Item::create($request->all());
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Item $item
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Item $item)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $item);
        $item->update($request->all());
        $this->crudSave($item);

        return new Resource($item);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Item $item
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Item $item)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $item);
        $item->delete();

        return response()->json(null, 204);
    }
}
