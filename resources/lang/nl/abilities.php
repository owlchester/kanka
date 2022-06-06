<?php

return [
    'abilities'     => [
        'title' => 'Gerelateerde vaardigheden van :name',
    ],
    'create'        => [
        'title' => 'Nieuwe Vaardigheid',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'abilities' => 'Vaardigheden',
        'ability'   => 'Bovenliggende Vaardigheid',
        'charges'   => 'Ladingen',
        'name'      => 'Naam',
        'type'      => 'Type',
    ],
    'helpers'       => [
        'descendants'   => 'Deze lijst bevat alle vaardigheden die afstammen van deze vaardigheid, en niet alleen die er direct onder hangen.',
    ],
    'index'         => [
        'title' => 'Vaardigheden',
    ],
    'placeholders'  => [
        'charges'   => 'Hoeveelheid ladingen. Referentie kenmerken met {Level}*{CHA}',
        'name'      => 'Vuurbal, Waarschuwing, Sluwe Aanval',
        'type'      => 'Spreuk, Prestatie, Aanval',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Vaardigheden',
        ],
    ],
];
