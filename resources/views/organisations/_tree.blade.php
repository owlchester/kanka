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
        // Name
        'name',
        'type',
        [
            'type' => 'location',
            'visible' => $campaignService->enabled('locations'),
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations')),
            'render' => function($model) {
                return $model->organisations->count();
            },
            'disableSort' => true,
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
    ])
    ->options(    [
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
