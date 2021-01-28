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
        'nested'        => 'In de Geneste Weergave kan je je Vaardigheden op een geneste manier bekijken. Vaardigheden zonder bovenliggende vaardigheid worden standaard weergegeven. Op Vaardigheden met subvaardigheden kan worden geklikt om die gerelateerden te bekijken. Je kunt blijven klikken totdat er geen gerelateerden meer te zien zijn.',
    ],
    'index'         => [
        'add'           => 'Nieuwe Vaardigheid',
        'description'   => 'Maak Krachten, Spreuken, Prestaties en meer voor je entiteiten.',
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
