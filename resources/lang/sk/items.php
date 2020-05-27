<?php

return [
    'create'        => [
        'description'   => 'Vytvoriť nový predmet',
        'success'       => 'Predmet :name vytvorený.',
        'title'         => 'Nový predmet',
    ],
    'destroy'       => [
        'success'   => 'Predmet :name odstránený.',
    ],
    'edit'          => [
        'success'   => 'Predmet :name upravený.',
        'title'     => 'Upraviť predmet :name',
    ],
    'fields'        => [
        'character' => 'Postava',
        'image'     => 'Obrázok',
        'location'  => 'Miesto',
        'name'      => 'Názov',
        'price'     => 'Cena',
        'relation'  => 'Prepojenie',
        'size'      => 'Veľkosť',
        'type'      => 'Typ',
    ],
    'index'         => [
        'add'           => 'Nový predmet',
        'description'   => 'Spravuj predmety objektu :name.',
        'header'        => 'Predmety objektu :name',
        'title'         => 'Predmety',
    ],
    'inventories'   => [
        'description'   => 'Objekty, v ktorých inventári sa tento objekt nachádza.',
        'title'         => 'Objekty s predmetom :name',
    ],
    'placeholders'  => [
        'character' => 'Vyber postavu',
        'location'  => 'Vyber miesto',
        'name'      => 'Názov predmetu',
        'price'     => 'Cena predmetu',
        'size'      => 'veľkosť, váha, rozmery',
        'type'      => 'zbraň, elixír, artefakt',
    ],
    'quests'        => [
        'description'   => 'Úlohy s týmto predmetom',
        'title'         => 'Úlohy s predmetom :name',
    ],
    'show'          => [
        'description'   => 'Detailný náhľad na predmet',
        'tabs'          => [
            'information'   => 'Informácie',
            'inventories'   => 'Objekty',
            'quests'        => 'Úlohy',
        ],
        'title'         => 'Predmet :name',
    ],
];
