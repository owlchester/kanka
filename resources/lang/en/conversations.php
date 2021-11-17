<?php

return [
    'create'        => [
        'success'   => 'Conversation \':name\' created.',
        'title'     => 'New Conversation',
    ],
    'destroy'       => [
        'success'   => 'Conversation \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Conversation \':name\' updated.',
        'title'     => 'Conversation :name',
    ],
    'fields'        => [
        'is_closed'     => 'Closed',
        'messages'      => 'Messages',
        'name'          => 'Name',
        'participants'  => 'Participants',
        'target'        => 'Target',
        'type'          => 'Type',
    ],
    'hints'         => [
        'participants'  => 'Please add participants to your conversation by pressing on the :icon icon on the upper-right.',
    ],
    'index'         => [
        'add'       => 'New Conversation',
        'header'    => 'Conversations in :name',
        'title'     => 'Conversations',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Message removed.',
        ],
        'is_updated'    => 'Updated',
        'load_previous' => 'Load previous messages',
        'placeholders'  => [
            'message'   => 'Your message',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Participant :entity added to the conversation.',
        ],
        'destroy'   => [
            'success'   => 'Participant :entity removed from the conversation.',
        ],
        'modal'     => 'Participants',
        'title'     => 'Participants of :name',
    ],
    'placeholders'  => [
        'name'  => 'Name of the conversation',
        'type'  => 'In Game, Prep, Plot',
    ],
    'show'          => [
        'is_closed' => 'Conversation is closed.',
        'title'     => 'Conversation :name',
    ],
    'tabs'          => [
        'conversation'  => 'Conversation',
        'participants'  => 'Participants',
    ],
    'targets'       => [
        'characters'    => 'Characters',
        'members'       => 'Members',
    ],
];
