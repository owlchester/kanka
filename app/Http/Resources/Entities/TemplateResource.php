<?php

namespace App\Http\Resources\Entities;

use App\Facades\CampaignLocalization;
use App\Models\Entity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
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

        $campaign = CampaignLocalization::getCampaign();

        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'url' => route('entities.create', [$campaign, $entity->entityType, 'copy' => $entity, 'template' => true])
        ];
    }
}
