<?php

namespace App\Http\Resources;

use App\Models\Reminder;

class ReminderResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Reminder $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'remindable_id' => $model->remindable_id,
            'remindable_type' => $model->remindable_type,
            'calendar_id' => $model->calendar_id,
            'date' => $model->date(),
            'day' => $model->day,
            'month' => $model->month,
            'year' => $model->year,
            'length' => $model->length,
            'comment' => $model->comment,
            'is_recurring' => (bool) $model->is_recurring,
            'recurring_until' => $model->recurring_until,
            'recurring_periodicity' => $model->recurring_periodicity,
            'colour' => $model->colour,
            'type_id' => $model->type_id,
            'visibility_id' => $model->visibility_id,

            'created_at' => $model->created_at,
            'created_by' => $model->created_by,
            'updated_at' => $model->updated_at,
            'updated_by' => $model->updated_by,
        ];
    }
}
