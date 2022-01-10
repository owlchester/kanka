<?php

namespace App\Http\Resources;

use App\Facades\Mentions;
use App\Facades\UserCache;
use App\Models\Campaign;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    use ApiSync;

    /**
     * @var bool
     */
    protected $withMentions = false;

    /**
     * @return $this
     */
    public function withMentions()
    {
        $this->withMentions = true;
        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Campaign $campaign */
        $campaign = $this->resource;

        $data = [
            'id' => $campaign->id,
            'name' => $campaign->name,
            'locale' => $campaign->locale,
            'entry' => $campaign->entry,
            'entry_parsed' => 'not available on the campaigns/ endpoint',
            'image' => $campaign->image,
            'image_full' => $campaign->getImageUrl(0),
            'image_thumb' => $campaign->getImageUrl(40),
            'visibility' => $campaign->isPublic() ? 'public' : 'private',
            'visibility_id' => $campaign->visibility_id,
            'created_at' => $campaign->created_at,
            'updated_at' => $campaign->updated_at,
            'settings' => $campaign->settings,
            'ui_settings' => $campaign->ui_settings,
            'default_images' => $campaign->default_images,

            'boosted' => $campaign->boosted(),
            'superboosted' => $campaign->boosted(true)
        ];

        if ($campaign->userIsMember() && auth()->user()->can('members', $campaign)) {
            $data['members'] = CampaignUserResource::collection($campaign->members);
        }

        if ($this->withMentions) {
            $data['entry_parsed'] = Mentions::mapCampaign($this->resource);
        }

        return $data;
    }
}
