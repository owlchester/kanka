<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EntityPermissionResource extends EntityChild
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
            'role' => $this->campaign_role_id,
            'user' => $this->user_id,
            'action' => $this->action,
            'access' => (bool) $this->access,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
