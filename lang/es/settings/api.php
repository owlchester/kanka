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
    'mcp'               => [
        'badge'         => 'MCP · solo lectura',
        'description'   => 'Conecta asistentes de IA con Kanka para buscar entradas de tus mundos mediante el Model Context Protocol. Agrega esta URL como servidor MCP HTTP con streaming en tu cliente.',
        'more'          => 'Obtén más información en tu página :mcp.',
        'title'         => 'Servidor MCP',
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
