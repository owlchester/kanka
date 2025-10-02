<?php /** @var \App\Models\Timeline $model */?>
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
            'type' => 'is_private',
        ]
    ])
    ->options([
        'route' => 'whiteboards.index',
        'baseRoute' => 'whiteboards',
        'trans' => 'whiteboards.fields.',
    ])
; !!}
