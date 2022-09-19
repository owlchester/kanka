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
            'label' => __('crud.fields.ability'),
            'field' => 'ability.name',
            'render' => function($model) {
                if ($model->ability) {
                    return $model->ability->tooltipedLink();
                }
            }
        ],
        [
            'label' => '<i class="ra ra-fire-symbol" title="' . __('abilities.fields.abilities') . '"></i>',
            'render' => function($model) {
                return $model->abilities->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-solid fa-user" title="' . __('abilities.show.tabs.entities') . '"></i>',
            'render' => function($model) {
                return $model->entities->count();
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
        'campaignService' => $campaignService
    ]
) !!}
