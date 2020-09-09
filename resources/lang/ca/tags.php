<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Afegeix una etiqueta nova',
        ],
        'create'        => [
            'title' => 'Afegeix una etiqueta a :name',
        ],
        'description'   => 'Entitats etiquetades',
        'title'         => 'Descendents de l\'etiqueta :name',
    ],
    'create'        => [
        'description'   => 'Crea una nova etiqueta',
        'success'       => 'S\'ha creat l\'etiqueta «:name».',
        'title'         => 'Nova etiqueta',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat l\'etiqueta «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'etiqueta «:name».',
        'title'     => 'Edita l\'etiqueta :name',
    ],
    'fields'        => [
        'characters'    => 'Personatges',
        'children'      => 'Entitats niades',
        'name'          => 'Nom',
        'tag'           => 'Etiqueta superior',
        'tags'          => 'Subetiquetes',
        'type'          => 'Tipus',
    ],
    'helpers'       => [
        'nested'    => 'Amb la vista niada, les etiquetes es mostren de forma agrupada. Les etiquetes sense cap superior es mostraran aquí per defecte. Les que tinguin subetiquetes niades es poden anar clicant per a mostrar-les. Es pot seguir clicant fins que no hi hagi més etiquetes niades a mostrar.',
    ],
    'hints'         => [
        'children'  => 'Aquí es mostren totes les entitats que pertanyen directament a aquesta etiqueta i a totes les etiquetes niades.',
        'tag'       => 'Aquí es mostren totes les etiquetes que estan directament sota aquesta etiqueta.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Vista niada',
        ],
        'add'           => 'Nova etiqueta',
        'description'   => 'Gestiona les etiquetes de :name.',
        'header'        => 'Etiquetes de :name',
        'title'         => 'Etiquetes',
    ],
    'new_tag'       => 'Nova etiqueta',
    'placeholders'  => [
        'name'  => 'Nom de l\'etiqueta',
        'tag'   => 'Trieu una etiqueta superior',
        'type'  => 'Tradicions, guerres, història, religió...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de l\'etiqueta',
        'tabs'          => [
            'children'      => 'Entitats niades',
            'information'   => 'Informació',
            'tags'          => 'Etiquetes',
        ],
        'title'         => 'Etiqueta :name',
    ],
    'tags'          => [
        'description'   => 'Subetiquetes',
        'title'         => 'Descendents de l\'etiqueta :name',
    ],
];
