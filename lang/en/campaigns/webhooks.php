<?php

return [
    'title'     => 'Webhooks',
    'destroy'    => [
        'success'   => 'Webhook deleted succesfully',
    ],
    'pitch'     => 'Create custom webhooks to recieve custom updates whenever an entity from the campaign is updated.',
    'actions'   => [
        'add'       =>  'Create webhook',
        'update'    =>  'Update webhook',
        'test'      =>  'Test webhook',
        'action'    =>  'Change status',
        'bulks'     =>  [
            'enable'            => 'Enable',
            'enable_success'    => '{1} Enabled :count webhook.|[2,*] Enabled :count webhooks.',
            'disable'           => 'Disable',
            'disable_success'   => '{1} Disabled :count webhook.|[2,*] Disabled :count webhooks.',
            'delete_success'    => '{1} Deleted :count webhook.|[2,*] Deleted :count webhooks.',
        ],
    ],
    'create'    => [
        'title' => 'Add new webhook',
        'success'   => 'Webhook created succesfully',
    ],
    'edit'      => [
        'title' => 'Update webhook',
        'success'   => 'Webhook updated succesfully',
    ],
    'test'      => [
        'success' => 'Test request sent',
    ],
    'fields'    => [
        'event'     => 'Event',
        'type'      => 'Type',
        'message'   => 'Message',
        'url'       => 'Url',
        'active'    => 'Active',
        'events'    => [
            'new'       => 'New entity',
            'edited'    => 'Edited entity',
            'deleted'   => 'Deleted entity',
        ],
        'types'     => [
            'payload'   => 'Payload',
            'custom'   => 'Message',
        ],
    ],
    'helper'    => [
        'active'    => 'If the webhook is currently active',
        'status'    => 'Toggle the active status of the webhook',
    ],
    'placeholders'  => [
        'url'       => 'Target webhook\'s url',
        'message'   => 'Message to append to the webhook',
    ],
];
