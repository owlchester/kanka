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
        [
            'label' => trans('families.fields.family'),
            'field' => 'family.name',
            'visible' => $campaignService->enabled('families'),
            'render' => function($model) {
                if ($model->family) {
                    return $model->family->tooltipedLink();
                }
            }
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
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'families.index',
        'baseRoute' => 'families',
        'trans' => 'families.fields.',
        'campaignService' => $campaignService
    ]
) !!}
