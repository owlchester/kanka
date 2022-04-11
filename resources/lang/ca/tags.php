<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Afegeix a l\'etiqueta',
        ],
        'create'    => [
            'success'   => 'S\'ha afegit l\'etiqueta :name a l\'entitat.',
            'title'     => 'Afegeix una etiqueta a :name',
        ],
        'title'     => 'Descendents de l\'etiqueta :name',
    ],
    'create'        => [
        'success'   => 'S\'ha creat l\'etiqueta «:name».',
        'title'     => 'Nova etiqueta',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat l\'etiqueta «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'etiqueta «:name».',
        'title'     => 'Edita l\'etiqueta :name',
    ],
    'fields'        => [
        'children'  => 'Entitats niades',
        'name'      => 'Nom',
        'tag'       => 'Etiqueta superior',
        'tags'      => 'Subetiquetes',
        'type'      => 'Tipus',
    ],
    'helpers'       => [
        'nested_parent' => 'S\'estan mostrant les etiquetes de :parent.',
        'nested_without'=> 'S\'estan mostrant les etiquetes sense pare. Feu clic a la fila d\'un mapa per a mostrar-ne les descendents.',
    ],
    'hints'         => [
        'children'  => 'Aquí es mostren totes les entitats que pertanyen directament a aquesta etiqueta i a totes les etiquetes niades.',
        'tag'       => 'Aquí es mostren totes les etiquetes que estan directament sota aquesta etiqueta.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'Vista niada',
        ],
        'add'       => 'Nova etiqueta',
        'header'    => 'Etiquetes de :name',
        'title'     => 'Etiquetes',
    ],
    'new_tag'       => 'Nova etiqueta',
    'placeholders'  => [
        'name'  => 'Nom de l\'etiqueta',
        'tag'   => 'Trieu una etiqueta superior',
        'type'  => 'Tradicions, guerres, història, religió...',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Entitats niades',
            'tags'      => 'Etiquetes',
        ],
        'title' => 'Etiqueta :name',
    ],
    'tags'          => [
        'title' => 'Descendents de l\'etiqueta :name',
    ],
];
