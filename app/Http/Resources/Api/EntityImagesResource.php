<?php

namespace App\Http\Resources\Api;

use App\Facades\Avatar;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Entity $entity */
        $entity = $this->resource;

        return [
            'image' => [
                'uuid' => $entity->image_uuid,
                'full' => Avatar::entity($entity)->original(),
                'thumbnail' => Avatar::entity($entity)->size(40)->thumbnail(),
                'description' => $entity->image?->description,
                'author' => $entity->image?->author,
            ],
            'header' => [
                'uuid' => $entity->header_uuid,
                'full' => $entity->header?->getUrl(),
                'thumbnail' => $entity->hasHeaderImage() ? $entity->getHeaderUrl() : null,
                'description' => $entity->header?->description,
                'author' => $entity->header?->author,
            ],
        ];
    }
}
