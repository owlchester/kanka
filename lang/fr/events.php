<?php

return [
    'create'        => [
        'title' => 'Nouvel Evénement',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Les événements qui ont cette entité comme événement parent sont affichés ici.',
    ],
    'fields'        => [
        'date'  => 'Date',
    ],
    'helpers'       => [
        'date'              => 'Ce champ peut contenir n\'importe quelle valeur et n\'est pas lié aux calendriers de la campagne. Pour lier cet événement à un calendrier, il faut se rendre sur l\'onglet rappels de cet événement.',
        'nested_without'    => 'Affichage des événements sans parent. Cliquer sur une rangée pour afficher les événements enfants.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'La date de l\'événement',
        'type'  => 'Cérémonie, Festival, Désastre, Bataille, Naissance',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Entrées calendrier',
    ],
];
