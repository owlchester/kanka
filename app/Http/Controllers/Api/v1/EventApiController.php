<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Event;
use App\Http\Requests\StoreEvent as Request;
use App\Http\Resources\EventResource as Resource;

class EventApiController extends ApiController
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
            ->events()
            ->with(['entity', 'entity.tags', 'entity.notes', 'entity.files',
                'entity.events', 'entity.relationships', 'entity.attributes'])
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Event $event
     * @return Resource
     */
    public function show(Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $event);
        return new Resource($event);
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
        $this->authorize('create', Event::class);
        $model = Event::create($request->all());
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Event $event
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $event);
        $event->update($request->all());
        $this->crudSave($event);

        return new Resource($event);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $event);
        $event->delete();

        return response()->json(null, 204);
    }
}
