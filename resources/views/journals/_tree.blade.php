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
