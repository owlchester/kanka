<?php

namespace App\Http\Controllers\Api\v1\Entities;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Requests\API\StoreReminder as Request;
use App\Http\Resources\ReminderResource as Resource;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Reminder;

class ReminderApiController extends ApiController
{
    public function index(Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);

        return Resource::collection($entity->reminders()->paginate());
    }

    public function show(Campaign $campaign, Entity $entity, Reminder $reminder)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $entity);
        $this->authorize('entity', [$reminder, $entity]);

        return new Resource($reminder);
    }

    public function store(Request $request, Campaign $campaign, Entity $entity)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $data = $request->all();
        if (! isset($data['length'])) {
            $data['length'] = 1;
        }
        $model = new Reminder($data);
        $model->remindable_id = $entity->id;
        $model->remindable_type = Entity::class;
        $model->save();

        return new Resource($model);
    }

    public function update(Request $request, Campaign $campaign, Entity $entity, Reminder $reminder)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $this->authorize('entity', [$reminder, $entity]);
        $reminder->update($request->all());

        return new Resource($reminder);
    }

    public function destroy(
        \Illuminate\Http\Request $request,
        Campaign $campaign,
        Entity $entity,
        Reminder $reminder
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $entity);
        $this->authorize('entity', [$reminder, $entity]);
        $reminder->delete();

        return response()->json(null, 204);
    }
}
