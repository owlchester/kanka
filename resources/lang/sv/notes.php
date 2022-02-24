<?php

return [
    'create'        => [
        'success'       => 'Anteckning \':name\' skapad.',
        'title'         => 'Ny Anteckning',
    ],
    'destroy'       => [
        'success'   => 'Anteckning \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Anteckning \':name\' uppdaterad.',
        'title'     => 'Redigera Anteckning :name',
    ],
    'fields'        => [
        'description'   => 'Beskrivning',
        'image'         => 'Bild',
        'is_pinned'     => 'Fastnålad',
        'name'          => 'Namn',
        'note'          => 'Huvudanteckning',
        'notes'         => 'Underanteckning',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'    => 'Visar anteckningar som inte har några huvudanteckningar först. Klicka på en anteckning för att visa dennes underanteckningar.',
    ],
    'hints'         => [
        'is_pinned' => 'Upp till 3 anteckningar kan vara fastnålade för att visas på dashborden.',
    ],
    'index'         => [
        'add'           => 'Ny Anteckning',
        'header'        => 'Anteckningar för :name',
        'title'         => 'Anteckningar',
    ],
    'placeholders'  => [
        'name'  => 'Namn på anteckningen',
        'note'  => 'Välj en huvudanteckning',
        'type'  => 'Religion, Ras, Politiskt System',
    ],
    'show'          => [
        'title'         => 'Anteckning :name',
    ],
];
