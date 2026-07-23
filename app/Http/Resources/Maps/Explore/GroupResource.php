<?php

namespace App\Http\Resources\Maps\Explore;

use App\Models\MapGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property MapGroup $resource
 */
class GroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'parent_id' => $this->resource->parent_id,
            'position' => $this->resource->position,
            'colour' => $this->resource->colour,
        ];
    }
}
