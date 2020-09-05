<?php

return [
    'create'        => [
        'description'   => 'Crea un nou esdeveniment',
        'success'       => 'S\'ha creat l\'esdeveniment «:name».',
        'title'         => 'Nou esdeveniment',
    ],
    'destroy'       => [
        'success'   => 'S\'ha esborrat l\'esdeveniment «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'esdeveniment «:name».',
        'title'     => 'Edita l\'esdeveniment :name',
    ],
    'fields'        => [
        'date'      => 'Data',
        'image'     => 'Imatge',
        'location'  => 'Localització',
        'name'      => 'Nomb',
        'type'      => 'Tipus',
    ],
    'helpers'       => [
        'date'  => 'Aquest camp pot contenir qualsevol cosa i no està vinculat als calendaris de la campanya. Per vincular aquest esdeveniment amb un calendari, afegiu-lo des de la pestanya de recordatoris o des del mateix calendari.',
    ],
    'index'         => [
        'add'           => 'Nou esdeveniment',
        'description'   => 'Gestiona els esdeveniments de :name.',
        'header'        => 'Esdeveniments de :name',
        'title'         => 'Esdeveniments',
    ],
    'placeholders'  => [
        'date'      => 'Data de l\'esdeveniment',
        'location'  => 'Trieu un indret',
        'name'      => 'Nom de l\'esdeveniment',
        'type'      => 'Cerimònia, festival, catàstrofe, batalla, naixement...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de l\'esdeveniment',
        'tabs'          => [
            'information'   => 'Informació',
        ],
        'title'         => 'Esdeveniment :name',
    ],
    'tabs'          => [
        'calendars' => 'Entrades del calendari',
    ],
];
