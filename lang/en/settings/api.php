<?php

return [
    'applications'      => [
        'title' => 'Authorised Applications',
    ],
    'clients'           => [
        'empty' => 'You have not created any OAuth clients.',
        'form'  => [
            'name'                  => 'Client Name',
            'name_helper'           => 'Something your users will recognise and trust.',
            'name_placeholder'      => 'Name of the client',
            'redirect'              => 'Redirect URL',
            'redirect_helper'       => 'Your application\'s authorisation callback URL.',
            'redirect_placeholder'  => 'http://my-super-app.com/callback',
        ],
        'new'   => 'Create New Client',
        'title' => 'OAuth Clients',
        'update'=> 'Update Client',
    ],
    'fields'            => [
        'client'        => 'Client ID',
        'client_name'   => 'Client Name',
        'scopes'        => 'Scopes',
        'secret'        => 'Secret',
        'token_name'    => 'Token Name',
    ],
    'new'               => [
        'copy'  => 'Token copied to the clipboard.',
        'title' => 'Your new personal access token:',
    ],
    'revoke'            => 'Revoke',
    'revoke-confirm'    => 'Confirm revocation',
    'tokens'            => [
        'empty' => 'You have not created any personal access tokens.',
        'form'  => [
            'name'              => 'Token Name',
            'name_placeholder'  => 'Name the token',
        ],
        'new'   => 'Create New Token',
        'title' => 'Personal Access Tokens',
    ],
];
