<?php

return [
    'applications'      => [
        'title' => 'Aplicaciones autorizadas',
    ],
    'clients'           => [
        'empty' => 'No has creado ningún cliente OAuth.',
        'form'  => [
            'name'                  => 'Nombre del cliente',
            'name_helper'           => 'Algo que tus usuarios reconozcan y en lo que confíen.',
            'name_placeholder'      => 'Nombre del cliente',
            'redirect'              => 'URL de redirección',
            'redirect_helper'       => 'La URL de callback de autorización de tu aplicación.',
            'redirect_placeholder'  => 'http://mi-super-app.com/callback',
        ],
        'new'   => 'Crear nuevo cliente',
        'title' => 'Clientes OAuth',
        'update'=> 'Actualizar cliente',
    ],
    'fields'            => [
        'client'        => 'ID del cliente',
        'client_name'   => 'Nombre del cliente',
        'scopes'        => 'Alcances',
        'secret'        => 'Secreto',
        'token_name'    => 'Nombre del token',
    ],
    'new'               => [
        'copy'  => 'Token copiado al portapapeles.',
        'title' => 'Tu nuevo token de acceso personal:',
    ],
    'revoke'            => 'Revocar',
    'revoke-confirm'    => 'Confirmar revocación',
    'tokens'            => [
        'empty' => 'No has creado ningún token de acceso personal.',
        'form'  => [
            'name'              => 'Nombre del token',
            'name_placeholder'  => 'Nombra el token',
        ],
        'new'   => 'Crear nuevo token',
        'title' => 'Tokens de acceso personal',
    ],
];
