<?php

namespace App\Http\Resources\Web;

use App\Facades\Avatar;
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
        if (! isset($this->campaign)) {
            dd($this);
        }

        return [
            'id' => $entity->id,
            'name' => $entity->name,
            'image' => Avatar::entity($entity)->size(192)->fallback()->thumbnail(),
            'link' => route('entities.show', [$this->campaign, $entity]),
            'tooltip' => route('entities.tooltip', [$this->campaign, $entity]),
        ];
    }
}
