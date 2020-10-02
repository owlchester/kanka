<?php /**
 * @var \App\Renderers\DatagridRenderer $datagrid
 * @var \App\Models\Journal $model
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
        'date',
        [
            'type' => 'calendar_date',
        ],
        [
            'label' => trans('journals.fields.journals'),
            'render' => function($model) {
                $count = $model->journals->count();
                return !empty($count) ? $count : '';
            },
            'disableSort' => true,
        ],
        [
            'label' => trans('journals.fields.journal'),
            'render' => function($model) {
                if ($model->note) {
                    return '<a href="' . route('journals.show', $model->journal) . '">' . e($model->journal->name) . '</a>';
                }
            },
            'field' => 'journal.name',
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
        'route' => 'journals.tree',
        'baseRoute' => 'journals',
        'trans' => 'journals.fields.',
        'row' => [
            'data' => [
                'data-children' => function($model) {
                    return $model->journals->count();
                }
            ],
        ]
    ]
) !!}
