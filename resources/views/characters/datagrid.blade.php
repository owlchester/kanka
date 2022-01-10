@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
    ->render(
    $filterService,
    [
        [
            'type' => 'avatar'
        ],
        'name',
        'title',
        [
            'label' => __('characters.fields.family'),
            'field' => 'family.name',
            'visible' => $campaign->enabled('families'),
            'render' => function($model) {
                if ($model->family) {
                    return $model->family->tooltipedLink();
                }
            }
        ],
        [
            'type' => 'location',
            'visible' => $campaign->enabled('locations'),
        ],
        [
            'label' => __('characters.fields.races'),
            'visible' => $campaign->enabled('races'),
            //'field' => 'races.id',
            'disableSort' => true,
            'render' => function($model) {
                $races = [];
                foreach ($model->races as $race) {
                    $races[] = $race->tooltipedLink();
                }
                return implode( ', ', $races);
            }
        ],
        'type',
        [
            'label' => '<i class="fas fa-transgender-alt" title="' . __('characters.fields.sex') . '"></i>',
            'field' => 'sex',
        ],
        [
            'label' => '<i class="ra ra-skull" title="' . __('characters.fields.is_dead') . '"></i>',
            'field' => 'is_dead',
            'render' => function($model) {
                if ($model->is_dead) {
                    return '<i class="ra ra-skull" title="' . __('characters.fields.is_dead') . '"></i>';
                }
                return '';
            },
            'class' => 'icon'
        ],
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
