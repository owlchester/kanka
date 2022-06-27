<?php

namespace App\Http\Resources;

use App\Facades\CampaignLocalization;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $user */
        $user = $this->resource;

        $campaign = CampaignLocalization::getCampaign();
        $roles = $user->campaignRoles->where('campaign_id', $campaign->id);

        return [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->getAvatarUrl(),
            'role' => CampaignUserRoleResource::collection($roles)
        ];
    }
}
