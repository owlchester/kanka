<?php

namespace App\Http\Resources;

use App\Facades\Mentions;
use App\Models\TimelineElement;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineElementResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var TimelineElement $model */
        $model = $this->resource;
        return [
            'id' => $model->id,
            'era_id' => $model->era_id,
            'timeline_id' => $model->timeline_id,
            'entity_id' => $model->entity_id,
            'name' => $model->name,
            'entry' => $model->entry,
            'entry_parsed' => Mentions::mapAny($model),
            'date' => $model->date,
            'colour' => $model->colour,
            'position' => $model->position,
            'visibility' => $model->visibility,
            'icon' => $model->icon
        ];
    }
}
