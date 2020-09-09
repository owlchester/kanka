<?php

return [
    'create'        => [
        'description'   => 'Crea una nota nova',
        'success'       => 'S\'ha creat la nota «:name».',
        'title'         => 'Nova nota',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat la nota «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat la nota «:name».',
        'title'     => 'Edita la nota :name',
    ],
    'fields'        => [
        'description'   => 'Descripció',
        'image'         => 'Imatge',
        'is_pinned'     => 'Fixada',
        'name'          => 'Nom',
        'type'          => 'Tipus',
    ],
    'hints'         => [
        'is_pinned' => 'Es poden fixar fins a 3 notes al tauler de la campanya.',
    ],
    'index'         => [
        'add'           => 'Nova nota',
        'description'   => 'Gestiona les notes de :name.',
        'header'        => 'Notes de :name',
        'title'         => 'Notes',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la nota',
        'type'  => 'Religió, relat, sistema polític...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la nota',
        'tabs'          => [
            'description'   => 'Descripció',
        ],
        'title'         => 'Nota :name',
    ],
];
