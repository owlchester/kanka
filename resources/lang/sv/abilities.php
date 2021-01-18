<?php

return [
    'abilities'     => [
        'title' => 'Underförmågor till :name',
    ],
    'create'        => [
        'success'   => 'Förmåga \':name\' skapad.',
        'title'     => 'Ny Förmåga',
    ],
    'destroy'       => [
        'success'   => 'Förmåga \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Förmåga \':name\' uppdaterad.',
        'title'     => 'Redigera Förmåga :name',
    ],
    'fields'        => [
        'abilities' => 'Förmågor',
        'ability'   => 'Huvudförmåga',
        'charges'   => 'Laddningar',
        'name'      => 'Namn',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Denna lista innehåller alla förmågor som har härletts från denna förmåga, och inte bara de direkt under denna.',
        'nested'        => 'I Hierarkisk Vy kan du se dina förmågor i hierarkisk ordning. Förmågor utan en huvudförmåga kommer visas som standard. Förmågor med underförmågor kan klickas på för att visa dessa. Du kan fortsätta klicka tills det inte finns fler underförmågor.',
    ],
    'index'         => [
        'add'           => 'Ny Förmåga',
        'description'   => 'Skapa Krafter, Trollformler, Bedrifter m.m. för dina entiteter.',
        'header'        => 'Förmågor till :name',
        'title'         => 'Förmågor',
    ],
    'placeholders'  => [
        'charges'   => 'Antal laddningar. Referera till egenskaper med {Level}*{CHA}',
        'name'      => 'Eldklot, Alert, Listigt Angrepp',
        'type'      => 'Trollformel, Bedrift, Angrep',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Förmågor',
        ],
        'title' => 'Förmåga :name',
    ],
];
