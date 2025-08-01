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
            'label' => '<i class="fa-regular fa-map" data-toggle="tooltip" data-title="' . __('maps.actions.explore') . '"></i>',
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
            'label' => '<i class="' . \App\Facades\Module::duoIcon('map') . '" title="' . \App\Facades\Module::plural(config('entities.ids.map'), __('entities.maps')) . '"></i>',
            'render' => function($model) {
                return number_format($model->children_count);
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
