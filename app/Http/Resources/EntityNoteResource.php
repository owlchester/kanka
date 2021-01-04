<?php

namespace App\Http\Resources;

use App\Facades\Mentions;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityNoteResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->entity([
            'name' => $this->name,
            'visibility' => $this->visibility,
            'entry' => $this->entry,
            'entry_parsed' => Mentions::mapEntityNote($this->resource),
            'is_pinned' => (bool) $this->is_pinned,
            'position' => $this->position,
        ]);
    }
}
