<?php /** @var \App\Renderers\DatagridRenderer $datagrid */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->filters($filters)
    ->nested()
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
            'label' => trans('locations.fields.locations'),
            'render' => function($model) {
                return $model->locations->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('locations.fields.location'),
            'render' => function($model) {
                if ($model->parentLocation) {
                    return '<a href="' . route('locations.show', $model->parentLocation->id) . '">' . e($model->parentLocation->name) . '</a>';
                }
            },
            'field' => 'parentLocation.name',
            'disableSort' => true,
        ],
        [
            'label' => trans('locations.fields.characters'),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                return $model->characters->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('locations.fields.map'),
            'field' => 'map',
            'render' => function($model) {
                if (!empty($model->map)) {
                    return '<a href="' . route('locations.map', $model) . '"><i class="fa fa-map"></i></a>';
                }
                return null;
            },
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
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