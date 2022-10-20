<?php

namespace App\Renderers\Layouts\Item;

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
                'label' => 'entities.item',
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
        ];

        return $columns;
    }
}
