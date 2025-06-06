<?php

namespace App\Http\Resources;

use App\Models\Post;

class PostResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Post $model */
        $model = $this->resource;

        return $this->onEntity([
            'name' => $model->name,
            'visibility_id' => (int) $model->visibility_id->value,
            'entry' => $model->entry,
            'entry_parsed' => $model->parsedEntry(),
            //            'is_pinned' => (bool) $this->is_pinned,
            'position' => $model->position,
            'settings' => $model->settings,
            'permissions' => PostPermissionResource::collection($model->permissions),
            'layout_id' => $model->layout_id,
            'is_template' => $model->isTemplate(),
            'tags' => $model->tags()->pluck('tags.id')->toArray(),
            'calendar_id' => $model->calendarDate?->calendar_id,
            'calendar_year' => $model->calendarDate?->year,
            'calendar_month' => $model->calendarDate?->month,
            'calendar_day' => $model->calendarDate?->day,
        ]);
    }
}
