<?php

return [
    'create'        => [
        'title' => 'New Conversation',
    ],
    'fields'        => [
        'is_closed'     => 'Closed',
        'messages'      => 'Messages',
        'participants'  => 'Participants',
    ],
    'hints'         => [
        'empty'         => 'There are no participants in this conversation.',
        'participants'  => 'Please add participants to the conversation by pressing on the :icon icon on the upper-right.',
    ],
    'lists'         => [
        'empty' => 'Record dialogues, letters, or exchanges between entities.',
    ],
    'messages'      => [
        'actions'           => 'Message actions',
        'confirm_delete'    => 'Delete this message?',
        'copied'            => 'Message copied to clipboard.',
        'copy_failed'       => 'Could not copy the message to the clipboard.',
        'destroy'           => [
            'success'   => 'Message removed.',
        ],
        'editing'           => 'Editing message',
        'empty'             => 'No messages yet.',
        'first_message'     => 'Start the conversation with a message.',
        'invalid_speaker'   => 'You can only speak as an eligible participant in this conversation.',
        'is_updated'        => 'Edited',
        'keyboard_hint'     => 'Enter to send · Shift+Enter for a new line',
        'load_previous'     => 'Load earlier messages',
        'loading'           => 'Loading messages…',
        'no_speaker'        => 'No participant available to speak as.',
        'placeholders'      => [
            'message'   => 'Your message',
        ],
        'refresh_failed'    => 'Your message was sent, but the conversation could not refresh.',
        'request_failed'    => 'The request failed. Please try again.',
        'retry'             => 'Retry',
        'saving'            => 'Saving…',
        'send'              => 'Send',
        'sending'           => 'Sending…',
        'speaking_as'       => 'Speaking as',
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Participant :entity added to the conversation.',
        ],
        'destroy'   => [
            'success'   => 'Participant :entity removed from the conversation.',
        ],
        'helper'    => 'Add and remove participants from :name.',
        'modal'     => 'Participants',
        'title'     => 'Participants of :name',
    ],
    'placeholders'  => [
        'name'  => 'Name of the conversation',
        'type'  => 'In Game, Prep, Plot',
    ],
    'show'          => [
        'is_closed' => 'Conversation is closed.',
    ],
    'tabs'          => [
        'participants'  => 'Participants',
    ],
    'targets'       => [
        'entities'  => 'Entities',
        'members'   => 'Members',
    ],
];
