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
            'label' => \App\Facades\Module::plural(config('entities.ids.creature'), __('entities.creatures')),
            'render' => function($model) {
                return $model->creatures->count();
            },
            'disableSort' => true,
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')),
            'render' => function($model) {
                $locations = [];
                foreach ($model->locations as $location) {
                    $locations[] = $location->tooltipedLink();
                }
                return implode( ', ', $locations);
            },
            'disableSort' => true,
        ],
        [
            'label' => '<i class="fa-solid fa-skull-cow" title="' . __('creatures.fields.is_extinct') . '"></i>',
            'field' => 'is_extinct',
            'render' => function($model) {
                if ($model->isExtinct()) {
                    return '<i class="fa-solid fa-skull-cow" title="' . __('creatures.fields.is_extinct') . '"></i>';
                }
                return '';
            },
            'class' => 'icon'
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'creatures.index',
        'baseRoute' => 'creatures',
        'trans' => 'creatures.fields.',
    ]
) !!}
