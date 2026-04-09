<?php

namespace App\Http\Resources\Api;

use App\Facades\Avatar;
use App\Models\CategoryStatus;
use App\Models\Entity;
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
            'is_default' => $model->is_default,
            'category_id' => $model->category_id,
        ];
    }
}
