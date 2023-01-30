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
    ],
    'helpers'       => [],
    'index'         => [],
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
