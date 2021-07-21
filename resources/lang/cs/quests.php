<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Přidat postavu k úkolu',
            'success'       => 'Postava přidána k úkolu :name.',
            'title'         => 'Nová postava pro :name',
        ],
        'destroy'   => [
            'success'   => 'Úkolová postava pro :name byla odstraněna.',
        ],
        'edit'      => [
            'description'   => 'Aktualizovat úkolovou postavu.',
            'success'       => 'Úkolová postava pro :name byla aktualizována.',
            'title'         => 'Aktualizovat postavu pro :name',
        ],
        'fields'    => [
            'character'     => 'Postava',
            'description'   => 'Popis',
        ],
        'title'     => 'Postavy v :name',
    ],
    'create'        => [
        'description'   => 'Vytvořit nový úkol',
        'success'       => 'Úkol :name byl vytvořen.',
        'title'         => 'Nový úkol',
    ],
    'destroy'       => [
        'success'   => 'Úkol :name byl odstraněn.',
    ],
    'edit'          => [
        'description'   => 'Upravit úkol',
        'success'       => 'Úkol :name byl aktualizován.',
        'title'         => 'Upravit úkol :name',
    ],
    'fields'        => [
        'characters'    => 'Postavy',
        'date'          => 'Datum',
        'description'   => 'Popis',
        'image'         => 'Obrázek',
        'is_completed'  => 'Dokončeno',
        'items'         => 'Předměty',
        'locations'     => 'Lokace',
        'name'          => 'Jméno',
        'organisations' => 'Organizace',
        'quest'         => 'Hlavní úkol',
        'quests'        => 'Podúkol',
        'role'          => 'Role',
        'type'          => 'Typ',
    ],
    'index'         => [
        'add'           => 'Nový úkol',
        'description'   => 'Správa úkolů pro :name.',
        'header'        => ':name úkol',
        'title'         => 'Úkoly',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Přidat do úkolu předmět',
            'success'       => 'Předmět přidán do :name.',
            'title'         => 'Nový předmět pro :name',
        ],
        'destroy'   => [
            'success'   => 'Úkolový předmět pro :name byl odstraněn.',
        ],
        'edit'      => [
            'description'   => 'Aktualizovat úkolový předmět',
            'success'       => 'Úkolový předmět pro :name byl upraven.',
            'title'         => 'Upravit předmět pro :name',
        ],
        'fields'    => [
            'description'   => 'Popis',
            'item'          => 'Předmět',
        ],
        'title'     => 'Předměty v :name',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Zadat pro úkol lokaci',
            'success'       => 'Lokace přidána pro :name.',
            'title'         => 'Nová lokace pro :name.',
        ],
        'destroy'   => [
            'success'   => 'Úkolová lokace pro :name odstraněna.',
        ],
        'edit'      => [
            'description'   => 'Upravit úkolovou lokaci.',
            'success'       => 'Úkolová lokace pro :name upravena.',
            'title'         => 'Upravit lokaci pro :name',
        ],
        'fields'    => [
            'description'   => 'Popis',
            'location'      => 'Lokace',
        ],
        'title'     => 'Lokace v :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Přidat do úkolu organizaci',
            'success'       => 'Organizace přidána do :name',
            'title'         => 'Nová organizace pro :name',
        ],
        'destroy'   => [
            'success'   => 'Úkolová organizace pro :name byla odstraněna.',
        ],
        'edit'      => [
            'description'   => 'Upravit úkol organizace',
            'success'       => 'Úkol organizace pro :name byl upraven.',
        ],
    ],
];
