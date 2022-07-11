@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
    ->render(
    $filterService,
    // Columns
    [
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
                    return '<a href="' . route('items.show', $model->item_id) . '">' . e($model->item->name) . '</a>';
                }
            }
        ],
        'price',
        'size',
        // Location
        [
            'type' => 'location',
            'visible' => $campaignService->enabled('locations'),
        ],
        // Character
        [
            'type' => 'character',
            'visible' => $campaignService->enabled('characters'),
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'items.index',
        'baseRoute' => 'items',
        'trans' => 'items.fields.',
        'campaignService' => $campaignService
    ]
) !!}
