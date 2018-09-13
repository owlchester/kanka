<?php

namespace App\Http\Controllers\Api;

use App\Models\Campaign;
use App\Models\Event;
use App\Http\Requests\StoreEvent as Request;
use App\Http\Resources\Event as Resource;
use App\Http\Resources\EventCollection as Collection;

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
        return new Collection($campaign->events);
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

        return new Resource($event);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(Request $request, Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $event);
        $event->delete();

        return response()->json(null, 204);
    }
}
