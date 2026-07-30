<?php

namespace App\Http\Resources\Maps\Explore;

use App\Models\MapLayer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @property MapLayer $resource
 */
class LayerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $layer = $this->resource;

        return [
            'id' => $layer->id,
            'name' => $layer->name,
            'type_id' => $layer->type_id,
            'image' => $layer->image ? $layer->image->url() : Storage::url($layer->image_path),
            'position' => $layer->position,
        ];
    }
}
