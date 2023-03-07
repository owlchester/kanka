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
            'label' => trans('notes.fields.note'),
            'field' => 'note.name',
            'render' => function($model) {
                if ($model->note) {
                return $model->note->tooltipedLink();
                }
            }
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
        'route' => 'notes.index',
        'baseRoute' => 'notes',
        'trans' => 'notes.fields.',
    ]
) !!}
