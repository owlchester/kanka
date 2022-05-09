<?php

namespace App\Http\Resources;

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
            'visibility_id' => $this->visibility_id,
            'is_equipped' => (bool) $this->is_equipped,
            'copy_item_entry' => (bool) $this->copy_item_entry,
            'description' => $this->description
        ]);
    }
}
