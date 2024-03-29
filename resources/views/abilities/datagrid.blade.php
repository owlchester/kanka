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
            'field' => 'ability.name',
            'render' => function($model) {
                if ($model->ability) {
                    return $model->ability->tooltipedLink();
                }
            }
        ],
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
        'route' => 'abilities.index',
        'baseRoute' => 'abilities',
        'trans' => 'abilities.fields.',
    ])
; !!}
