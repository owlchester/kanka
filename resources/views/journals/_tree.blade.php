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
        [
            'label' => __('journals.fields.date'),
            'field' => 'date',
            'render' => function ($model) {
                return \App\Facades\UserDate::format($model->date);
            }
        ],
        [
            'type' => 'calendar_date',
        ],
        [
            'field' => 'author.name',
            'label' => __('journals.fields.author'),
            'render' => function($model) {
                return $model->author ? $model->author->tooltipedLink() : null;
            },
        ],
        [
            'label' => \App\Facades\Module::plural(config('entities.ids.journal'), __('entities.journals')),
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
