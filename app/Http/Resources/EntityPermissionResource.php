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
        return $this->entity([
            'role' => $this->campaign_role_id,
            'user' => $this->user_id,
            'action' => $this->action,
            'access' => $this->access,
        ]);
    }
}
