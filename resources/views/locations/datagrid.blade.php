<?php /** @var \App\Models\Location $model */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)->render(
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
            'label' => trans('locations.fields.location'),
            'field' => 'parentLocation.name',
            'render' => function($model) {
                if ($model->parentLocation) {
                    return '<a href="' . route('locations.show', $model->parentLocation->id) . '" data-toggle="tooltip" data-html="true" title="' . $model->parentLocation->tooltipWithName() . '">' . e($model->parentLocation->name) . '</a>';
                }
            }
        ],
        [
            'label' => trans('locations.fields.characters'),
            'visible' => $campaign->enabled('characters'),
            'render' => function($model) {
                $total = $model->characters->count();
                foreach ($model->descendants()->with('characters')->get() as $child) {
                    $total += $child->characters->count();
                }
                return $total;
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('locations.fields.map'),
            'field' => 'map',
            'render' => function($model) {
                if (!empty($model->map) && (!$model->is_map_private || auth()->check() && auth()->user()->can('map', $model))) {
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
        'route' => 'locations.index',
        'baseRoute' => 'locations',
        'trans' => 'locations.fields.',
    ]
) !!}