<?php

return [
    'create'        => [
        'description'   => 'Create a new conversation',
        'success'       => 'Conversation \':name\' created.',
        'title'         => 'New Conversation',
    ],
    'destroy'       => [
        'success'   => 'Conversation \':name\' removed.',
    ],
    'edit'          => [
        'description'   => 'Update the conversation',
        'success'       => 'Conversation \':name\' updated.',
        'title'         => 'Conversation :name',
    ],
    'fields' => [
        'target' => 'Target',
        'name' => 'Name',
        'participants' => 'Participants',
        'messages' => 'Messages',
        'type' => 'Type',
    ],
    'hints' => [
        'participants' => 'Please add participants to your conversation.',
    ],
    'index'         => [
        'add'           => 'New Conversation',
        'description'   => 'Manage the category of :name.',
        'header'        => 'Conversations in :name',
        'title'         => 'Conversations',
    ],
    'messages' => [
        'load_previous' => 'Load previous messages',
        'placeholders' => [
            'message' => 'Your message',
        ]
    ],
    'participants' => [
        'modal' => 'Participants',
        'description' => 'Add or remove participants of a conversation',
        'title' => 'Participants of :name',
        'create' => [
            'success' => 'Participant :entity added to the conversation.',
        ],
        'destroy' => [
            'success' => 'Participant :entity removed from the conversation.',
        ]
    ],
    'placeholders'  => [
        'name'      => 'Name of the conversation',
        'type'      => 'In Game, Prep, Plot',
    ],
    'show'          => [
        'description'   => 'A detailed view of a conversation',
        'title'         => 'Conversation :name',
    ],
    'tabs' => [
        'conversation' => 'Conversation',
        'participants' => 'Participants',
    ],
    'targets' => [
        'members' => 'Members',
        'characters' => 'Characters',
    ]
];
