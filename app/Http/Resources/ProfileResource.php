<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'avatar' => $this->getAvatarUrl(),
            'avatar_thumb' => $this->getAvatarUrl(true),
            'locale' => $this->locale,
            'timezone' => $this->timezone,
            'date_format' => $this->date_format,
            'default_pagination' => $this->default_pagination,
            'last_campaign_id' => $this->last_campaign_id,
            'is_patreon' => $this->hasRole('patreon')
        ];
    }
}
