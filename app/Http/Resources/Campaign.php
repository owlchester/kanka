<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Campaign extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'locale' => $this->locale,
            'entry' => $this->entry,
            'image' => $this->image,
            'image_full' => $this->getImageUrl(),
            'image_thumb' => $this->getImageUrl(true),
            'visibility' => $this->visibility,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'members' => new CampaignUserCollection($this->members)
        ];
    }
}
