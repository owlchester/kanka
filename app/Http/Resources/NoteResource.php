<?php

namespace App\Http\Resources;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Note $model */
        $model = $this->resource;

        return $this->entity([
        ]);
    }
}
