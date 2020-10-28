<?php /**
 * @var \App\Renderers\DatagridRenderer $datagrid
 * @var \App\Models\Note $model
 */?>
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
            'label' => trans('notes.fields.notes'),
            'render' => function($model) {
                $count = $model->notes->count();
                return !empty($count) ? $count : '';
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('notes.fields.note'),
            'render' => function($model) {
                if ($model->note) {
                    return '<a href="' . route('notes.show', $model->note) . '">' . e($model->note->name) . '</a>';
                }
            },
            'field' => 'note.name',
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ],
    // Data
    $models,
    // Options
    [
        'route' => 'notes.tree',
        'baseRoute' => 'notes',
        'trans' => 'notes.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->notes->count();
                }
            ],
        ]
    ]
) !!}
