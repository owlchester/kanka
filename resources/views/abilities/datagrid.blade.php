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
            'label' => trans('crud.fields.ability'),
            'field' => 'ability.name',
            'render' => function($model) {
                if ($model->ability) {
                    return $model->ability->tooltipedLink();
                }
            }
        ],
        [
            'label' => '<i class="fa fa-users" title="' . trans('abilities.fields.abilities') . '"></i>',
            'render' => function($model) {
                return $model->abilities->count();
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
        'route' => 'abilities.index',
        'baseRoute' => 'abilities',
        'trans' => 'abilities.fields.',
        'campaign' => $campaign
    ]
) !!}
