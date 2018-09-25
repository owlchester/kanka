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
        'title',
        [
            'label' => trans('characters.fields.family'),
            'field' => 'family.name',
            'visible' => $campaign->enabled('families'),
            'render' => function($model) {
                if ($model->family) {
                    return '<a href="' . route('families.show', $model->family->id) . '" data-toggle="tooltip" title="' . $model->family->tooltip() . '">' . $model->family->name . '</a>';
                }
            }
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => trans('characters.fields.race'),
            'field' => 'race.name',
            'visible' => $campaign->enabled('races'),
            'render' => function($model) {
                if ($model->race) {
                    return '<a href="' . route('races.show', $model->race_id) . '" data-toggle="tooltip" title="' . $model->race->tooltip() . '">' . $model->name . '</a>';
                }
            }
        ],
        'type',
        'age',
        'sex',
        'is_dead',
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'characters.index',
        'baseRoute' => 'characters',
        'trans' => 'characters.fields.',
        'campaign' => $campaign
    ]
) !!}