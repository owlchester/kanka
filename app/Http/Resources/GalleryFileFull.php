<?php

namespace App\Http\Resources;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryFileFull extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Image $file */
        $file = $this->resource;

        $mentions = [];
        foreach ($file->inEntities() as $entity) {
            $mentions[] = [
                'url' => $entity->url(),
                'name' => $entity->name,
                'type' => 'image',
            ];
        }
        foreach ($file->mentions as $mention) {
            if ($mention->isPost()) {
                $mentions[] = [
                    'url' => $mention->entity->url() . '?#post-' . $mention->post_id,
                    'name' => $mention->post->name,
                    'type' => 'post',
                ];
            } else {
                $mentions[] = [
                    'url' => $mention->entity->url(),
                    'name' => $mention->entity->name,
                    'type' => 'entity',
                ];
            }
        }
        return [
            'mentions' => $mentions
        ];
    }
}
