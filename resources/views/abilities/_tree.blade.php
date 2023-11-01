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
            'label' => '<i class="' . \App\Facades\Module::duoIcon('ability') . '" title="' . __('entities.abilities') . '"></i>',
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
    ])
    ->options([
        'route' => 'abilities.tree',
        'baseRoute' => 'abilities',
        'trans' => 'abilities.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->abilities->count();
                }
            ]
        ]
    ])
; !!}
