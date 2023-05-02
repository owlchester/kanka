<?php /**
 * @var \App\Renderers\DatagridRenderer $datagrid
 * @var \App\Models\Note $model
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
            'label' => \App\Facades\Module::plural(config('entities.ids.note'), __('entities.notes')),
            'render' => function($model) {
                $count = $model->notes->count();
                return !empty($count) ? $count : '';
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options(    [
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
