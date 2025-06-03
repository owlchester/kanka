<?php

return [
    'create'        => [
        'title' => 'Nouvel Evénement',
    ],
    'events'        => [
        'helper'    => 'Les événements qui ont cette entité comme événement parent sont affichés ici.',
    ],
    'fields'        => [
        'date'  => 'Date',
    ],
    'helpers'       => [
        'date'  => 'Ce champ peut contenir n\'importe quelle valeur et n\'est pas lié aux calendriers de la campagne. Pour lier cet événement à un calendrier, il faut se rendre sur l\'onglet rappels de cet événement.',
    ],
    'placeholders'  => [
        'date'  => 'La date de l\'événement',
        'type'  => 'Cérémonie, Festival, Désastre, Bataille, Naissance',
    ],
    'tabs'          => [
        'calendars' => 'Entrées calendrier',
    ],
];
