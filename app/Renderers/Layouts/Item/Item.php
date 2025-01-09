<?php

namespace App\Renderers\Layouts\Item;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Item extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'render' => Standard::IMAGE
            ],
            'name' => [
                'key' => 'name',
                'label' => Module::singular(config('entities.ids.item'), 'entities.item'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'price' => [
                'key' => 'price',
                'label' => 'items.fields.price',
            ],
            'size' => [
                'key' => 'size',
                'label' => 'items.fields.size',
            ],
            'weight' => [
                'key' => 'weight',
                'label' => 'items.fields.weight',
            ],
        ];

        return $columns;
    }
}
