<?php /** @var \App\Models\Map $model */ ?>
{!! $datagrid
    ->columns([
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'type',
        [
            'type' => 'parent',
        ],
        [
            'label' => '<i class="fa-solid fa-map" data-toggle="tooltip" data-title="' . __('maps.actions.explore') . '"></i>',
            'render' => function($model) use ($campaign) {
                return \Illuminate\Support\Facades\Blade::render('maps._explore-link', ['map' => $model, 'campaign' => $campaign]);
            },
            'disableSort' => true,
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.map'), __('entities.maps')),
            'render' => function($model) {
                return $model->children->count();
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'maps.index',
        'baseRoute' => 'maps',
        'trans' => 'maps.fields.',
    ]
) !!}
