<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\API\StoreReminder as Request;
use App\Http\Resources\ReminderResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Reminder;

class ReminderApiController extends ApiController
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
    public function show(Campaign $campaign, Entity $entity, Reminder $reminder)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return new Resource($reminder);
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
        $model = new Reminder($data);
        $model->remindable_id = $entity->id;
        $model->remindable_type = Entity::class;
        $model->save();

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Entity $entity, Reminder $reminder)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $reminder->update($request->all());

        return new Resource($reminder);
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
        Reminder $reminder
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $reminder->delete();

        return response()->json(null, 204);
    }
}
