<?php

return [
    'abilities'     => [
        'title' => 'Gerelateerde vaardigheden van :name',
    ],
    'create'        => [
        'success'   => 'Vaardigheid \':name\' gemaakt.',
        'title'     => 'Nieuwe Vaardigheid',
    ],
    'destroy'       => [
        'success'   => 'Vaardigheid \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Vaardigheid \':name\' bijgewerkt.',
        'title'     => 'Wijzig Vaardigheid :name',
    ],
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
        'add'           => 'Nieuwe Vaardigheid',
        'header'        => 'Vaardigheden van :name',
        'title'         => 'Vaardigheden',
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
        'title' => 'Vaardigheid :name',
    ],
];
