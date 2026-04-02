<?php

namespace App\Http\Resources;

use App\Models\CategoryStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var CategoryStatus $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'key' => $model->key,
            'is_custom' => $model->isCustom(),
        ];
    }
}
