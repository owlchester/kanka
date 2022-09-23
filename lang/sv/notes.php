<?php

return [
    'create'        => [
        'title' => 'Ny Anteckning',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'description'   => 'Beskrivning',
        'image'         => 'Bild',
        'is_pinned'     => 'Fastnålad',
        'name'          => 'Namn',
        'note'          => 'Huvudanteckning',
        'notes'         => 'Underanteckning',
        'type'          => 'Typ',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_pinned' => 'Upp till 3 anteckningar kan vara fastnålade för att visas på dashborden.',
    ],
    'index'         => [
        'title' => 'Anteckningar',
    ],
    'placeholders'  => [
        'name'  => 'Namn på anteckningen',
        'note'  => 'Välj en huvudanteckning',
        'type'  => 'Religion, Ras, Politiskt System',
    ],
    'show'          => [],
];
