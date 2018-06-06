@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->render(
    $filterService,
    // Columns
    [
        // Name
        'name',
        // Entity
        [
            'type' => 'avatar',
            'parent' => 'entity',
            'parent_route' => function($model) {
                return $model->entity->pluralType();
            },
        ],
        [
            'type' => 'entity',
        ],
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
        'campaign' => $campaign
    ]
) !!}