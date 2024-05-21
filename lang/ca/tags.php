<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Afegeix a l\'etiqueta',
        ],
    ],
    'create'        => [
        'title' => 'Nova etiqueta',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Entitats niades',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Aquí es mostren totes les entitats que pertanyen directament a aquesta etiqueta i a totes les etiquetes niades.',
        'tag'       => 'Aquí es mostren totes les etiquetes que estan directament sota aquesta etiqueta.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Tradicions, guerres, història, religió...',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Entitats niades',
        ],
    ],
    'tags'          => [],
];
