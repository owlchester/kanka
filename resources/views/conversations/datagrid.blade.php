<?php /** @var \App\Models\Conversation $model */ ?>

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
            'label' => __('conversations.fields.participants'),
            'field' => 'target_id',
            'render' => function($model) {
                return __('conversations.targets.' . ($model->forCharacters() ? 'characters' : 'members'));
            },
        ],
        [
            'label' => __('conversations.fields.participants'),
            'render' => function($model) {
                return number_format($model->participants_count);
            },
            'disableSort' => true,
        ],
        [
            'label' => __('conversations.fields.messages'),
            'render' => function($model) {
                return number_format($model->messages_count);
            },
            'disableSort' => true,
        ],
        [
            'type' => 'is_private',
        ],
    ])
    ->options([
        'route' => 'conversations.index',
        'baseRoute' => 'conversations',
        'trans' => 'conversations.fields.',
    ]
) !!}
