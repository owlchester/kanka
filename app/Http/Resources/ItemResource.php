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
            'price' => $model->price,
            'size' => $model->size,
            'weight' => $model->weight,
            'item_id' => $model->item_id,
            'creator_id' => $model->creator_id,
        ]);
    }
}
