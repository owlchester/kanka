<?php

return [
    'create'        => [
        'title' => 'Nieuwe Notitie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_pinned' => 'Vastgemaakt',
        'note'      => 'Bovenliggende Notitie',
        'notes'     => 'Sub Notities',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_pinned' => 'Er kunnen maximaal 3 notities worden vastgemaakt om op het dashboard te worden weergegeven.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Naam van de notitie',
        'note'  => 'Kies een bovenliggende notitie',
        'type'  => 'Religie, Ras, Politiek systeem',
    ],
    'show'          => [],
];
