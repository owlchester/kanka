<?php

namespace App\Services\Maps;

use App\Http\Resources\Maps\Explore\GroupResource;
use App\Http\Resources\Maps\Explore\LayerResource;
use App\Http\Resources\Maps\Explore\MapResource;
use App\Http\Resources\Maps\Explore\PinResource;
use App\Models\Map;
use App\Traits\CampaignAware;

class ExploreApiService
{
    use CampaignAware;

    protected Map $map;

    public function map(Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function load(): array
    {
        return [
            'map' => new MapResource($this->map)->campaign($this->campaign),
            'layers' => LayerResource::collection(
                $this->map->layers
                    ->filter(fn ($layer) => $layer->typeName() === 'overlay_shown' && $layer->hasImage())
                    ->values()
            ),
            'groups' => GroupResource::collection($this->map->groups),
            'pins' => PinResource::collection(
                $this->map->markers->filter(fn ($marker) => $marker->visible())->values()
            ),
        ];
    }
}
