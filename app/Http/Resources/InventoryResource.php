<?php

namespace App\Http\Resources;

use App\Models\Inventory;

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
        /** @var Inventory $model */
        $model = $this->resource;

        return $this->onEntity([
            'item_id' => $model->item_id,
            'name' => $model->name,
            'position' => $model->position,
            'amount' => $model->amount,
            'visibility_id' => $model->visibility_id,
            'is_equipped' => (bool) $model->is_equipped,
            'copy_item_entry' => (bool) $model->copy_item_entry,
            'description' => $model->description,
        ]);
    }
}
