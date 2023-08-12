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
            'field' => 'race.name',
            'visible' => $campaign->enabled('races'),
            'render' => function($model) {
                if ($model->race) {
                    return $model->race->tooltipedLink();
                }
            }
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.character'), __('entities.characters')),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->characters->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'races.index',
        'baseRoute' => 'races',
        'trans' => 'races.fields.',
    ]
) !!}
