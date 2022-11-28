<?php /** @var \App\Models\Location $model */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
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
            'label' => __('locations.fields.location'),
            'field' => 'parentLocation.name',
            'render' => function($model) {
                if ($model->parentLocation) {
                return $model->parentLocation->tooltipedLink();
                }
            }
        ],
        [
            'label' => __('locations.fields.characters'),
            'visible' => $campaignService->enabled('characters'),
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
            'label' => null,
            'field' => 'map',
            'render' => function($model) {
                if (!empty($model->map) && (!$model->is_map_private || auth()->check() && auth()->user()->can('map', $model))) {
                    return '<a href="' . route('locations.map', $model) . '"><i class="fa-solid fa-map"></i></a>';
                }
                return null;
            },
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'locations.index',
        'baseRoute' => 'locations',
        'trans' => 'locations.fields.',
    ]
) !!}
