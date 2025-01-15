<?php

namespace App\Http\Resources;

use App\Models\Note;

class NoteResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Note $model */
        $model = $this->resource;
        return $this->entity([
            'note_id' => $model->note_id,
        ]);
    }
}
