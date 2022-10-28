<?php

return [
    'create'        => [
        'title' => 'Ny Anteckning',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_pinned' => 'Fastnålad',
        'note'      => 'Huvudanteckning',
        'notes'     => 'Underanteckning',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_pinned' => 'Upp till 3 anteckningar kan vara fastnålade för att visas på dashborden.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Namn på anteckningen',
        'note'  => 'Välj en huvudanteckning',
        'type'  => 'Religion, Ras, Politiskt System',
    ],
    'show'          => [],
];
