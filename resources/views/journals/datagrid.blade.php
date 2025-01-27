<?php /** @var \App\Models\Journal $model */?>

{!! $datagrid
    ->columns([
        [
            'type' => 'avatar'
        ],
        'name',
        'type',
        [
            'type' => 'parent',
        ],
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
            'render' => function($model) use ($campaign) {
                if (!$model->author) {
                    return '';
                }
                return \Illuminate\Support\Facades\Blade::renderComponent(
                    new \App\View\Components\EntityLink($model->author, $campaign)
                );
            },
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'journals.index',
        'baseRoute' => 'journals',
        'trans' => 'journals.fields.',
    ]
) !!}
