@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->campaign($campaign)
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
        //Item_id
        [
            'label' => __('items.fields.item'),
            'field' => 'item_id',
            'render' => function($model) {
                if ($model->item) {
                    return '<a href="' . $model->getLink() . '">' . e($model->item->name) . '</a>';
                }
            }
        ],
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
        'route' => 'items.index',
        'baseRoute' => 'items',
        'trans' => 'items.fields.',
    ]
) !!}
