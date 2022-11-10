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
            'label' => trans('families.fields.families'),
            'render' => function($model) {
                return $model->families->count();
            },
            'disableSort' => true,
        ],
        // Location
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
            'label' => '<i class="fa-solid fa-users" title="' . trans('families.fields.members') . '"></i>',
            'visible' => $campaignService->enabled('characters'),
            'render' => function($model) {
                return $model->members->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'families.tree',
        'baseRoute' => 'families',
        'trans' => 'families.fields.',
        'campaignService' => $campaignService,
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->families->count();
                }
            ]
        ]
    ]
) !!}
