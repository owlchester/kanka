@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->nested()
    ->service($filterService)
    ->models($models)
    ->columns([
        // Avatar
        [
            'type' => 'avatar'
        ],
        'name',
        'type',
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
            'type' => 'location',
            'visible' => $campaignService->enabled('locations'),
        ],
        [
            'type' => 'character',
            'visible' => $campaignService->enabled('characters'),
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'items.tree',
        'baseRoute' => 'items',
        'trans' => 'items.fields.',
        'row' => [
            'data' => [
                'data-children' =>function($model){
                    return $model->items->count();
                }
                ]
            ]
    ]
) !!}
