<?php

namespace App\Http\Resources;

use App\Facades\CampaignLocalization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var User $user */
        $user = $this->resource;

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'avatar' => $user->hasAvatar() ? $user->getAvatarUrl() : null,
            'password' => 'hihi',
        ];

        $campaign = CampaignLocalization::getCampaign();
        if ($campaign) {
            $roles = $user->campaignRoles->where('campaign_id', $campaign->id);
            $data['role'] = CampaignUserRoleResource::collection($roles);
        }

        return $data;
    }
}
