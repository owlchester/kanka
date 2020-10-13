<?php

return [
    'create'        => [
        'description'   => 'Vytvoriť novú poznámku',
        'success'       => 'Poznámka :name vytvorená.',
        'title'         => 'Nová poznámka',
    ],
    'destroy'       => [
        'success'   => 'Poznámka :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Poznámka :name upravená.',
        'title'     => 'Upraviť poznámku :name',
    ],
    'fields'        => [
        'description'   => 'Popis',
        'image'         => 'Obrázok',
        'is_pinned'     => 'Pripnutá',
        'name'          => 'Názov',
        'note'          => 'Nadradená poznámka',
        'notes'         => 'Podradená poznámka',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'    => 'Poznámky bez nadradených poznámok sa zobrazia ako prvé. Klikni na poznámku, ak chceš zobraziť jej podradené.',
    ],
    'hints'         => [
        'is_pinned' => 'Na nástenku môžete pripnúť max. 3 poznámky.',
    ],
    'index'         => [
        'add'           => 'Nová poznámka',
        'description'   => 'Spravuj poznámky objektu :name.',
        'header'        => 'Poznámky objektu :name',
        'title'         => 'Poznámky',
    ],
    'placeholders'  => [
        'name'  => 'Názov poznámky',
        'note'  => 'Vybrať nadradenú poznámku',
        'type'  => 'náboženstvo, rasa, politický systém',
    ],
    'show'          => [
        'description'   => 'Detailný náhľad poznámky',
        'tabs'          => [
            'description'   => 'Popis',
        ],
        'title'         => 'Poznámka :name',
    ],
];
