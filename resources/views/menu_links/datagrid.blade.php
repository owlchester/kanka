@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
    ->render(
    $filterService,
    // Columns
    [
        // Name
        'name',
        'position',
        // Entity
        [
            'type' => 'avatar',
            'parent' => 'target',
            'parent_route' => function($model) {
                return $model->target->pluralType();
            },
        ],
        [
            'label' => __('menu_links.fields.entity'),
            'render' => function($model) {
                if ($model->target) {
                    return $model->target->tooltipedLink();
                } elseif (empty($model->type)) {
                    // Link to a no-longer existing entity
                    return '';
                }
                return __('entities.' . \Illuminate\Support\Str::plural($model->type));
            },
            'disableSort' => true,
        ],
        'menu',
        'tab',
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'menu_links.index',
        'baseRoute' => 'menu_links',
        'trans' => 'menu_links.fields.',
        'campaign' => $campaign,
        'disableEntity' => true,
    ]
) !!}
