@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->render(
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
            'render' => function($model) {
                if ($model->parentLocation) {
                    return '<a href="' . route('locations.show', $model->parentLocation->id) . '">' . $model->parentLocation->name . '</a>';
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
            }
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