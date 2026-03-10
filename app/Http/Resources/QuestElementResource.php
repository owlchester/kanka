<?php

namespace App\Http\Resources;

use App\Models\QuestElement;

class QuestElementResource extends ModelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var QuestElement $model */
        $model = $this->resource;

        return $this->entity([
            'entity_id' => $model->entity_id,
            'name' => $model->name,
            'entry' => $model->entry,
            'entry_parsed' => ! empty($model->entry) ? $model->parsedEntry() : null,
            'colour' => $model->colour,
            'role' => $model->role,
            'visibility_id' => $model->visibility_id,
        ]);
    }
}
