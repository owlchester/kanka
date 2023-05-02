@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
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
            'type' => 'organisation',
            'label' => __('crud.fields.parent')
        ],
        [
            'type' => 'location',
            'visible' => $campaignService->enabled('locations'),
        ],
        [
            'label' => '<i class="fa-solid fa-users" title="' . trans('organisations.fields.members') . '"></i>',
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
        'route' => 'organisations.index',
        'baseRoute' => 'organisations',
        'trans' => 'organisations.fields.',
        'campaignService' => $campaignService
    ]
) !!}
