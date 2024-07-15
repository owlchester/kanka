<?php

return [
    'actions'       => [
        'action'    => 'Change status',
        'add'       => 'Create webhook',
        'bulks'     => [
            'delete_success'    => '{1} Deleted :count webhook.|[2,*] Deleted :count webhooks.',
            'disable'           => 'Disable',
            'disable_success'   => '{1} Disabled :count webhook.|[2,*] Disabled :count webhooks.',
            'enable'            => 'Enable',
            'enable_success'    => '{1} Enabled :count webhook.|[2,*] Enabled :count webhooks.',
        ],
        'test'      => 'Test webhook',
        'update'    => 'Update webhook',
    ],
    'create'        => [
        'success'   => 'Webhook created successfully',
        'title'     => 'Add new webhook',
    ],
    'destroy'       => [
        'success'   => 'Webhook deleted successfully',
    ],
    'edit'          => [
        'success'   => 'Webhook updated successfully',
        'title'     => 'Update webhook',
    ],
    'fields'        => [
        'enabled'           => 'Enabled',
        'event'             => 'Event',
        'events'            => [
            'deleted'   => 'Deleted entity',
            'edited'    => 'Edited entity',
            'new'       => 'New entity',
        ],
        'message'           => 'Message',
        'private_entities'  => [
            'helper'    => 'Don\'t trigger the webhook when updating private entities.',
            'skip'      => 'Skip private entities',
        ],
        'type'              => 'Type',
        'types'             => [
            'custom'    => 'Message',
            'payload'   => 'Payload',
        ],
        'url'               => 'Url',
    ],
    'helper'        => [
        'active'    => 'If the webhook is currently active',
        'message'   => 'Add a custom message with support for mappings',
        'status'    => 'Toggle the active status of the webhook',
    ],
    'pitch'         => 'Create custom webhooks to receive custom updates whenever an entity from the campaign is updated.',
    'placeholders'  => [
        'message'   => '{who} made changes to {name}, check it out at {url}',
        'url'       => 'Target webhook\'s url',
    ],
    'test'          => [
        'success'   => 'Test request sent',
    ],
    'title'         => 'Webhooks',
];
