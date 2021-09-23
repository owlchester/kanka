<?php

namespace App\Http\Resources;

use App\Facades\Mentions;
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
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'locale' => $this->locale,
            'entry' => $this->entry,
            'entry_parsed' => 'not available on the campaigns/ endpoint',
            'image' => $this->image,
            'image_full' => $this->getImageUrl(0),
            'image_thumb' => $this->getImageUrl(40),
            'visibility' => $this->visibility,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'members' => CampaignUserResource::collection($this->members),
            'settings' => $this->settings,
            'ui_settings' => $this->ui_settings,
            'default_images' => $this->default_images,
            'css' => $this->css,
        ];

        if ($this->withMentions) {
            $data['entry_parsed'] = Mentions::mapCampaign($this->resource);
        }

        return $data;
    }
}
