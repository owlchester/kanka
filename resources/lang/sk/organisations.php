<?php

return [
    'create'        => [
        'success'   => 'Organizácia :name vytvorená.',
        'title'     => 'Nová organizácia',
    ],
    'destroy'       => [
        'success'   => 'Organizácia :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Organizácia :name upravená.',
        'title'     => 'Upraviť organizáciu :name',
    ],
    'fields'        => [
        'image'         => 'Obrázok',
        'location'      => 'Miesto',
        'members'       => 'Členovia',
        'name'          => 'Názov',
        'organisation'  => 'Nadradená organizácia',
        'organisations' => 'Podradená organizácia',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Tento zoznam obsahuje všetky organizácie, ktoré sú podradené tejto a všetkým podradeným organizáciám.',
        'nested_parent' => 'Zobraziť organizácie :parent.',
        'nested_without'=> 'Zobraziť všetky organizácie, ktoré nemajú nadradenú organizáciu. Kliknutím na riadok zobrazíš podradené organizácie.',
    ],
    'index'         => [
        'title' => 'Organizácie',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Pridať člena',
        ],
        'create'        => [
            'success'   => 'Člen pridaný do organizácie.',
            'title'     => 'Nový člen organizácie :name',
        ],
        'destroy'       => [
            'success'   => 'Člen odstránený z organizácie.',
        ],
        'edit'          => [
            'success'   => 'Člen organizácie upravený.',
            'title'     => 'Upraviť člena organizácie :name',
        ],
        'fields'        => [
            'character'     => 'Postava',
            'organisation'  => 'Organizácia',
            'parent'        => 'Nadriadená osoba',
            'pinned'        => 'Pripnuté',
            'role'          => 'Rola',
            'status'        => 'Stav členstva',
        ],
        'helpers'       => [
            'all_members'   => 'Všetky postavy, ktoré sú členmi tejto a podradených organizácií.',
            'members'       => 'Všetky postavy, ktoré sú členmi tejto organizácie',
            'pinned'        => 'Zvoľ, či toto členstvo má byť zobrazené v sekcii pripnutých v prehľade priradených objektov.',
        ],
        'pinned'        => [
            'both'          => 'Oboje',
            'character'     => 'Postava',
            'none'          => 'Žiadne',
            'organisation'  => 'Organizácia',
        ],
        'placeholders'  => [
            'character' => 'Vyber postavu',
            'parent'    => 'Kto je nadriadená osoba tohto člena?',
            'role'      => 'veliteľ, členka, veľkňaz, majsterka špiónov',
        ],
        'status'        => [
            'active'    => 'Aktívne členstvo',
            'inactive'  => 'Neaktívne členstvo',
            'unknown'   => 'Neznámy stav',
        ],
        'title'         => 'Členovia organizácie :name',
    ],
    'organisations' => [
        'title' => 'Organizácie organizácie :name',
    ],
    'placeholders'  => [
        'location'  => 'Vyber miesto',
        'name'      => 'Názov organizácie',
        'type'      => 'kult, gang, bunka revolúcie, fandom',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizácie',
        ],
    ],
];
