<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Event;
use App\Http\Requests\StoreEvent as Request;
use App\Http\Resources\EventResource as Resource;

class EventApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->events()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $event->entity);
        return new Resource($event);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', EntityType::find(config('entities.ids.event')));

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Event::create($data);
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $event->entity);
        $event->update($request->all());
        $this->crudSave($event);

        return new Resource($event);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $event->entity);
        $event->delete();

        return response()->json(null, 204);
    }
}
