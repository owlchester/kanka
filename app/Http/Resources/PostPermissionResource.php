<?php

namespace App\Http\Resources;

use App\Models\PostPermission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostPermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var PostPermission $model */
        $model = $this->resource;

        return [
            'user_id' => $model->user_id,
            'role_id' => $model->role_id,
            'permission' => $model->permission,
            'permission-text' => $model->permText(),
        ];
    }
}
