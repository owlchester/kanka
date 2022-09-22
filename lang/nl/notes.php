<?php

return [
    'create'        => [
        'title' => 'Nieuwe Notitie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'description'   => 'Beschrijving',
        'image'         => 'Afbeelding',
        'is_pinned'     => 'Vastgemaakt',
        'name'          => 'Naam',
        'note'          => 'Bovenliggende Notitie',
        'notes'         => 'Sub Notities',
        'type'          => 'Type',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_pinned' => 'Er kunnen maximaal 3 notities worden vastgemaakt om op het dashboard te worden weergegeven.',
    ],
    'index'         => [
        'title' => 'Notities',
    ],
    'placeholders'  => [
        'name'  => 'Naam van de notitie',
        'note'  => 'Kies een bovenliggende notitie',
        'type'  => 'Religie, Ras, Politiek systeem',
    ],
    'show'          => [],
];
