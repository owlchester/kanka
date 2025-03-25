<?php

namespace App\Http\Resources;

use App\Facades\CampaignCache;
use App\Facades\Mentions;
use App\Facades\UserCache;
use App\Models\Campaign;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class CampaignResource extends JsonResource
{
    use ApiSync;

    protected $withMentions = false;

    public function withMentions(): self
    {
        $this->withMentions = true;

        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        /** @var Campaign $campaign */
        $campaign = $this->resource;

        $url = route('dashboard', $campaign);
        $apiViewUrl = 'campaigns.show';

        $data = [
            'id' => $campaign->id,
            'slug' => $campaign->slug,
            'name' => $campaign->name,
            'locale' => $campaign->locale,
            'entry' => $campaign->entry,
            'entry_parsed' => 'not available on the campaigns/ endpoint',
            'image' => $campaign->image,
            'image_full' => $campaign->thumbnail(0),
            'image_thumb' => $campaign->thumbnail(),
            'visibility' => $campaign->isPublic() ? 'public' : 'private',
            'visibility_id' => $campaign->visibility_id,
            'created_at' => $campaign->created_at,
            'updated_at' => $campaign->updated_at,
            'settings' => $campaign->settings,
            'ui_settings' => $campaign->ui_settings,
            'default_images' => $campaign->default_images,
            'follower' => $campaign->follower,
            'boosted' => $campaign->boosted(),
            'superboosted' => $campaign->superboosted(),
            'premium' => $campaign->premium(),
            'is_hidden' => (bool) $campaign->is_hidden,

            'urls' => [
                'view' => $url,
                'api' => Route::has($apiViewUrl) ? route($apiViewUrl, [$campaign]) : null,
            ],
        ];

        CampaignCache::campaign($campaign)->user(auth()->user());
        UserCache::campaign($campaign)->user(auth()->user());
        if ($campaign->userIsMember() && auth()->user()->can('members', $campaign)) {
            $data['members'] = CampaignUserResource::collection($campaign->members);
        }

        if ($this->withMentions) {
            $data['entry_parsed'] = Mentions::mapAny($this->resource);
        }

        // Hide stuff like sidebar
        unset($data['ui_settings']['sidebar']);

        return $data;
    }
}
