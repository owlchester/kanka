<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\API\StoreReminder as Request;
use App\Http\Resources\ReminderResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Reminder;

class EntityEventApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return Resource::collection($entity->reminders()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Entity $entity, Reminder $entityEvent)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new Resource($entityEvent);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->all();
        $data['entity_id'] = $entity->id;
        $model = Reminder::create($data);
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, Reminder $entityEvent)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityEvent->update($request->all());

        return new Resource($entityEvent);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        Reminder $entityEvent
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $entityEvent->delete();

        return response()->json(null, 204);
    }
}
