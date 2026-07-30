<?php

namespace App\Http\Resources\Maps\Explore;

use App\Models\Entity;
use App\Models\Preset;
use App\Traits\CampaignAware;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Preset $resource
 */
class PresetResource extends JsonResource
{
    use CampaignAware;

    protected Entity $mapEntity;

    public function mapEntity(Entity $mapEntity): self
    {
        $this->mapEntity = $mapEntity;

        return $this;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'config' => $this->resource->config ?? [],
            'update_url' => route('entities.map-presets.update', [$this->campaign->id, $this->mapEntity->id, $this->resource->id]),
            'destroy_url' => route('entities.map-presets.destroy', [$this->campaign->id, $this->mapEntity->id, $this->resource->id]),
        ];
    }
}
