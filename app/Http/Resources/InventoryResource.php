<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends EntityChild
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
            'item_id' => $this->item_id,
            'name' => $this->name,
            'position' => $this->position,
            'amount' => $this->amount,
            'visibility' => $this->visibility,
            'is_equipped' => (bool) $this->is_equipped,
        ]);
    }
}
