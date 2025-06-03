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
                return \Illuminate\Support\Facades\Blade::renderComponent(
                    new \App\View\Components\Date(date: $model->date)
                );
            }
        ],
        [
            'type' => 'reminder',
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
            'label' => '<i class="' . \App\Facades\Module::duoIcon('journal') . '" title="' . \App\Facades\Module::plural(config('entities.ids.journal'), __('entities.journals')) . '"></i>',
            'render' => function($model) {
                return number_format($model->children_count);
            },
            'disableSort' => true,
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
