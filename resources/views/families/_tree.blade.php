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
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.family'), __('entities.families')),
            'render' => function($model) {
                return $model->families->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => '<i class="fa-solid fa-users" title="' . trans('families.fields.members') . '"></i>',
            'visible' => $campaign->enabled('characters'),
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
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->families->count();
                }
            ]
        ]
    ]
) !!}
