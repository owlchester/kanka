@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->campaign($campaign)
    ->nested()
    ->service($filterService)
    ->models($models)
    ->columns([
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'type',
        'price',
        'size',
        // Location
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        // Character
        [
            'type' => 'character',
            'visible' => $campaign->enabled('characters'),
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
