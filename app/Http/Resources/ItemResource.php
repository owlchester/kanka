<?php

namespace App\Http\Resources;

use App\Models\Item;

class ItemResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Item $model */
        $model = $this->resource;
        return $this->entity([
            'type' => $model->type,
            'price' => $model->price,
            'size' => $model->size,
            'weight' => $model->weight,
            'item_id' => $model->item_id,
        ]);
    }
}
