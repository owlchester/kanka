<?php

return [
    'create'        => [
        'success'       => 'Notitie \':name\' gemaakt.',
        'title'         => 'Nieuwe Notitie',
    ],
    'destroy'       => [
        'success'   => 'Notitie \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Notitie \':name\' bijgewerkt.',
        'title'     => 'Wijzig Notitie :name',
    ],
    'fields'        => [
        'description'   => 'Beschrijving',
        'image'         => 'Afbeelding',
        'is_pinned'     => 'Vastgemaakt',
        'name'          => 'Naam',
        'note'          => 'Bovenliggende Notitie',
        'notes'         => 'Sub Notities',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'Toon eerst notities die geen bovenliggende notitie hebben. Klik op een notitie om de subnotities ervan te bekijken.',
    ],
    'hints'         => [
        'is_pinned' => 'Er kunnen maximaal 3 notities worden vastgemaakt om op het dashboard te worden weergegeven.',
    ],
    'index'         => [
        'add'           => 'Nieuwe Notitie',
        'header'        => 'Notities van :name',
        'title'         => 'Notities',
    ],
    'placeholders'  => [
        'name'  => 'Naam van de notitie',
        'note'  => 'Kies een bovenliggende notitie',
        'type'  => 'Religie, Ras, Politiek systeem',
    ],
    'show'          => [
        'title'         => 'Notitie :name',
    ],
];
