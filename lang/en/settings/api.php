<?php

return [
    'new' => [
        'title' => 'Your new personal access token:',
        'helper' => 'Your new personal access token:',
        'copy' => 'Token copied to the clipboard.',
    ],
    'fields' => [
        'client' => 'Client ID',
        'scopes' => 'Scopes',
        'secret' => 'Secret',
        'client_name' => 'Client Name',
        'token_name' => 'Token Name',
    ],
    'tokens'     => [
        'title' => 'Personal Access Tokens',
        'new' => 'Create New Token',
        'empty' => 'You have not created any personal access tokens.',
        'form' => [
            'name' => 'Token Name',
            'name_placeholder' => 'Name the token',
        ],
    ],
    'clients'     => [
        'title' => 'OAuth Clients',
        'new' => 'Create New Client',
        'update' => 'Update Client',
        'empty' => 'You have not created any OAuth clients.',
        'form' => [
            'name' => 'Client Name',
            'name_placeholder' => 'Name of the client',
            'name_helper' => 'Something your users will recognize and trust.',
            'redirect' => 'Redirect URL',
            'redirect_helper' => 'Your application\'s authorization callback URL.',
            'redirect_placeholder' => 'http://my-super-app.com/callback',
        ],
    ],
    'applications' => [
        'title' => 'Authorized Applications',
    ],
];
