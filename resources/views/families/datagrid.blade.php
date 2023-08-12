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
        [
            'label' => __('crud.fields.parent'),
            'field' => 'family.name',
            'render' => function($model) {
                if ($model->family) {
                    return $model->family->tooltipedLink();
                }
            }
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
        'route' => 'families.index',
        'baseRoute' => 'families',
        'trans' => 'families.fields.',
    ]
) !!}
