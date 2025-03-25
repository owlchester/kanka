<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreItem as Request;
use App\Http\Resources\ItemResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Item;

class ItemApiController extends ApiController
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
            ->items()
            ->has('entity')
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Item $item)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $item->entity);

        return new Resource($item);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.item')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        /** @var Item $model */
        $model = Item::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Item $item)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $item->entity);
        $item->update($request->all());
        $this->crudSave($item);

        return new Resource($item);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Item $item)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $item->entity);
        $item->delete();

        return response()->json(null, 204);
    }
}
