<?php

namespace App\Http\Resources;

use App\Models\Note;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'type' => $model->type,
            'note_id' => $model->note_id,
        ]);
    }
}
