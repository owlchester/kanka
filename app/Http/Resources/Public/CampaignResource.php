<?php

namespace App\Http\Resources\Public;

use App\Models\Campaign;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Campaign $campaign */
        $campaign = $this->resource;

        return [
            'id' => $campaign->id,
            'thumb' => $campaign->image ? $campaign->thumbnail(320, 240) : 'https://th.kanka.io/zzKcBpijSBvm4rPWdzRpI82pTNQ=/320x240/smart/src/app/backgrounds/mountain-background-medium.jpg',
            'name' => $campaign->name,
            'justify' => $campaign->spotlight?->url,
            'link' => route('dashboard', $campaign),
            'followers' => number_format($campaign->follower),
            'entities' => number_format($campaign->visible_entity_count),
            'locale' => $campaign->locale,
            'system' => $campaign->getSystems(),
            'is_open' => $campaign->isOpen(),
        ];
    }
}
