<?php

namespace App\Http\Resources;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationResource extends EntityChild
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Application $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'user_id' => $model->user_id,
            'text' => $model->text,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
