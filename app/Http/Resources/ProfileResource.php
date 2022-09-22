<?php

namespace App\Http\Resources;

use App\User;
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
            'avatar' => $model->getAvatarUrl(200),
            'avatar_thumb' => $model->getAvatarUrl(),
            'locale' => $model->locale,
            'timezone' => $model->timezone,
            'date_format' => $model->date_format,
            'default_pagination' => $model->default_pagination,
            'last_campaign_id' => $model->last_campaign_id,
            'is_patreon' => $model->isSubscriber()
        ];
    }
}
