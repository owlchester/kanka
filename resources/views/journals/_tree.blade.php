<?php /**
 * @var \App\Renderers\DatagridRenderer $datagrid
 * @var \App\Models\Journal $model
 */?>
@inject ('datagrid', 'App\Renderers\DatagridRenderer')

{!! $datagrid
    ->nested()
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
        'date',
        [
            'type' => 'calendar_date',
        ],
        [
            'label' => __('journals.fields.journals'),
            'render' => function($model) {
                $count = $model->journals->count();
                return !empty($count) ? $count : '';
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
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
