<?php /** @var \App\Models\Whiteboard $model */?>
{!! $datagrid
    ->columns([
        // Avatar
        [
            'type' => 'avatar'
        ],
        // Name
        'name',
        'type',
        [
            'label' => '<i class="fa-regular fa-chalkboard" data-toggle="tooltip" data-title="' . __('whiteboards.actions.draw') . '"></i>',
            'render' => function($model) use ($campaign) {
                return \Illuminate\Support\Facades\Blade::render('whiteboards._draw-link', ['model' => $model, 'campaign' => $campaign]);
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'whiteboards.index',
        'baseRoute' => 'whiteboards',
        'trans' => 'whiteboards.fields.',
    ])
; !!}
