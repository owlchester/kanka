<?php

return [
    'create'        => [
        'title' => 'Nova conversa',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Conversa ":name"',
    ],
    'fields'        => [
        'is_closed'     => 'Pechada',
        'messages'      => 'Mensaxes',
        'participants'  => 'Participantes',
    ],
    'hints'         => [
        'participants'  => 'Engade participantes á conversa presionando a icona :icon arriba á dereita.',
    ],
    'index'         => [],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Mensaxe eliminada.',
        ],
        'is_updated'    => 'Actualizada',
        'load_previous' => 'Cargar mensaxes previas',
        'placeholders'  => [
            'message'   => 'A túa mensaxe',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Participante :entity engadida á conversa.',
        ],
        'destroy'   => [
            'success'   => 'Participante :entity eliminada da conversa.',
        ],
        'modal'     => 'Participantes',
        'title'     => 'Participantes de ":name"',
    ],
    'placeholders'  => [
        'name'  => 'Nome da conversa',
        'type'  => 'Dentro do xogo, preparación, argumento...',
    ],
    'show'          => [
        'is_closed' => 'A conversa está pechada.',
    ],
    'tabs'          => [
        'conversation'  => 'Conversa',
        'participants'  => 'Participantes',
    ],
    'targets'       => [
        'characters'    => 'Personaxes',
        'members'       => 'Integrantes',
    ],
];
