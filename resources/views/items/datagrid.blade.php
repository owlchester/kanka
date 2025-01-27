<?php /** @var \App\Models\Item $model */ ?>

{!! $datagrid
    ->columns([
        [
            'type' => 'avatar'
        ],
        'name',
        'type',
        [
            'type' => 'parent',
        ],
        [
            'label' => '<i class="fa-solid fa-coins" aria-hidden="true" title="' . __('items.fields.price') . '"></i> <span class="sr-only">' . __('items.fields.price') . '</span>',
            'field' => 'price',
            'render' => function($model) {
                return $model->price;
            }
        ],
        [
            'label' => '<i class="fa-solid fa-ruler-combined" aria-hidden="true" title="' . __('items.fields.size') . '"></i> <span class="sr-only">' . __('items.fields.size') . '</span>',
            'field' => 'size',
            'render' => function($model) {
                return $model->size;
            }
        ],
        [
            'label' => '<i class="fa-solid fa-weight-hanging" aria-hidden="true" title="' . __('items.fields.weight') . '"></i> <span class="sr-only">' . __('items.fields.weight') . '</span>',
            'field' => 'weight',
            'render' => function($model) {
                return $model->weight;
            }
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => __('items.fields.character'),
            'type' => 'character',
            'visible' => $campaign->enabled('characters'),
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'items.index',
        'baseRoute' => 'items',
        'trans' => 'items.fields.',
    ]
) !!}
