<?php

namespace App\Http\Resources;

use App\Models\CampaignUser;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var CampaignUser $resource */
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'user' => new UserResource($resource->user),
        ];
    }
}
