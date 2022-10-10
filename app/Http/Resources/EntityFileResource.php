<?php

namespace App\Http\Resources;

use App\Models\EntityFile;
use Illuminate\Support\Facades\Storage;

class EntityFileResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityFile $model */
        $model = $this->resource;
        return $this->entity([
            'name' => $model->name,
            'visibility_id' => $model->visibility_id,
            'type' => $model->type,
            'path' => Storage::url($model->path),
            'size' => $model->size,
        ]);
    }
}
