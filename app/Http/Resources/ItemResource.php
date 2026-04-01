<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
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
            'creators' => $model->itemCreators->pluck('creator_id'),
        ]);
    }
}
