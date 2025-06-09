<?php

namespace App\Http\Resources;

use App\Models\TimelineElement;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineElementResource extends JsonResource
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
            'entry_parsed' => $model->parsedEntry(),
            'date' => $model->date,
            'colour' => $model->colour,
            'position' => $model->position,
            'visibility_id' => $model->visibility_id,
            'icon' => $model->icon,
            'is_collapsed' => $model->collapsed(),
            'use_entity_entry' => $model->use_entity_entry,
        ];
    }
}
