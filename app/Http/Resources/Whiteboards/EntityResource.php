<?php

namespace App\Http\Resources\Whiteboards;

use App\Models\Entity;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
{
    use CampaignAware;

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
            'id' => $entity->id,
            'name' => $entity->name,
            'link' => $entity->url(),
            'preview' => route('entities.tooltip', [$this->campaign, $entity]),
        ];
    }
}
