<?php

namespace App\Http\Resources;

use App\Models\QuestElement;
use Illuminate\Http\Request;

class QuestElementResource extends ModelResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
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
            'copy_entity_entry' => (bool) $model->copy_entity_entry,
            'colour' => $model->colour,
            'role' => $model->role,
            'visibility_id' => $model->visibility_id,
        ]);
    }
}
