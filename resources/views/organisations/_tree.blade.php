@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->filters($filters)
    ->nested()
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
        [
            'label' => trans('organisations.fields.organisations'),
            'render' => function($model) {
                return $model->organisations->count();
            },
            'disableSort' => true,
        ],
        // location
        [
            'type' => 'avatar',
            'parent' => 'location',
            'parent_route' => 'locations',
            'visible' => $campaignService->enabled('locations'),
        ],
        [
            'type' => 'location',
            'visible' => $campaignService->enabled('locations'),
        ],
        [
            'label' => '<i class="fa-solid fa-users" title="' . __('organisations.fields.members') . '"></i>',
            'visible' => $campaignService->enabled('characters'),
            'render' => function($model) {
                return $model->members->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-solid fa-shop-slash" title="' . __('organisations.fields.is_defunct') . '"></i>',
            'field' => 'is_defunct',
            'render' => function($model) {
                if ($model->isDefunct()) {
                    return '<i class="fa-solid fa-shop-slash" title="' . __('organisations.fields.is_defunct') . '"></i>';
                }
                return '';
            },
            'class' => 'icon'
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'organisations.tree',
        'baseRoute' => 'organisations',
        'trans' => 'organisations.fields.',
        'campaignService' => $campaignService,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->organisations->count();
                }
            ]
        ]
    ]
) !!}
