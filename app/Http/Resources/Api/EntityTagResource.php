<?php

namespace App\Http\Resources\Api;

use App\Models\EntityTag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityTagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var EntityTag $model */
        $model = $this->resource;

        return [
            'tag_id' => $model->tag_id,
        ];
    }
}
