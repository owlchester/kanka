<?php /** @var \App\Renderers\DatagridRenderer $datagrid */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->campaign($campaign)
    ->nested()
    ->service($filterService)
    ->models($models)
    ->columns([
        [
            'type' => 'avatar'
        ],
        'name',
        'type',
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')),
            'render' => function($model) {
                return $model->locations->count();
            },
            'disableSort' => true,
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
        'route' => 'locations.tree',
        'baseRoute' => 'locations',
        'trans' => 'locations.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->locations->count();
                }
            ],
        ]
    ]
) !!}
