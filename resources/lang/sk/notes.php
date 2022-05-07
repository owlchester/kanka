<?php

return [
    'create'        => [
        'success'   => 'Poznámka :name vytvorená.',
        'title'     => 'Nová poznámka',
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
        'nested_parent' => 'Zobraziť poznámky :parent.',
        'nested_without'=> 'Zobraziť všetky poznámky, ktoré nemajú nadradenú poznámku. Kliknutím na riadok zobrazíš podradené poznámky.',
    ],
    'hints'         => [
        'is_pinned' => 'Na nástenku môžete pripnúť max. 3 poznámky.',
    ],
    'index'         => [
        'title' => 'Poznámky',
    ],
    'placeholders'  => [
        'name'  => 'Názov poznámky',
        'note'  => 'Vybrať nadradenú poznámku',
        'type'  => 'náboženstvo, rasa, politický systém',
    ],
    'show'          => [],
];
