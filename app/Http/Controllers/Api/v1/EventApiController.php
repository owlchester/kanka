<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreEvent as Request;
use App\Http\Resources\EventResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Event;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
     * @return resource
     */
    public function show(Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $event->entity);

        return new Resource($event);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.event')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Event::create($data);
        $this->crudSave($model, $request->validated());

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $event->entity);
        $event->update($request->all());
        $this->crudSave($event, $request->validated());

        return new Resource($event);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, Event $event)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $event->entity);
        $event->delete();

        return response()->json(null, 204);
    }
}
