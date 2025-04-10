<?php

namespace App\Http\Resources;

use App\Facades\Img;
use App\Models\User;
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
        /** @var User $model */
        $model = $this->resource;

        return [
            'id' => $model->id,
            'name' => $model->name,
            'avatar' => $model->hasAvatar() ? Img::resetCrop()->url($model->avatar) : null,
            'avatar_thumb' => $model->hasAvatar() ? $model->getAvatarUrl() : null,
            'locale' => $model->locale,
            'timezone' => $model->timezone,
            'date_format' => $model->dateformat,
            'default_pagination' => $model->pagination,
            'last_campaign_id' => $model->last_campaign_id,
            'is_patreon' => $model->isSubscriber(),
            'is_subscriber' => $model->isSubscriber(),
            'rate_limit' => $model->rate_limit,
        ];
    }
}
