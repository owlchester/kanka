<?php

return [
    'create'    => [
        'helper'    => 'Créer un rappel pour lier :name à un calendrier.',
    ],
    'fields'    => [
        'type'  => 'Type d\'événement',
    ],
    'helpers'   => [
        'characters'    => 'Définir le type comme la date de naissance ou de mort pour ce personnage calculera automatiquement leur âge. :more.',
        'founding'      => 'Définir le type comme :type calculera automatiquement l\'âge de fondation de l\'entité.',
        'reminders'     => 'Les rappels liés à :name seront affichés ici.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Ajouter un rappel',
        ],
        'title'     => 'Rappels pour :name',
    ],
    'types'     => [
        'birth'     => 'Naissance',
        'birthday'  => 'Anniversaire',
        'death'     => 'Décès',
        'founded'   => 'Fondé',
        'primary'   => 'Principal',
    ],
    'years-ago' => '{1} il y a :count année|[2,*] il y a :count année',
];
