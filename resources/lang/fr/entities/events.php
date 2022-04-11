<?php

return [
    'fields'    => [
        'type'  => 'Type d\'événement',
    ],
    'helpers'   => [
        'characters'    => 'Définir le type comme la date de naissance ou de mort pour ce personnage calculera automatiquement leur âge. :more.',
        'no_events'     => 'Cette interface affiche les calendriers liés à cette entité à travers les rappels.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Ajouter un rappel',
        ],
        'title'     => 'Rappels pour :name',
    ],
    'types'     => [
        'birth'     => 'Naissance',
        'death'     => 'Décès',
        'primary'   => 'Principal',
    ],
];
