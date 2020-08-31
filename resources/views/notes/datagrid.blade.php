@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid->filters($filters)
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
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'notes.index',
        'baseRoute' => 'notes',
        'trans' => 'notes.fields.',
        'campaign' => $campaign
    ]
) !!}
