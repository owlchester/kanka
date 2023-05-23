<?php

return [
    'create'        => [
        'title' => 'Nová organizácia',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'Nečinná',
        'members'       => 'Členovia',
    ],
    'helpers'       => [
        'descendants'       => 'Tento zoznam obsahuje všetky organizácie, ktoré sú podradené tejto a všetkým podradeným organizáciám.',
        'nested_without'    => 'Zobraziť všetky organizácie, ktoré nemajú nadradenú organizáciu. Kliknutím na riadok zobrazíš podradené organizácie.',
    ],
    'hints'         => [
        'is_defunct'    => 'Táto organizácia už ukončila činnosť.',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'       => 'Pridať člena',
            'submit'    => 'Pridať člena',
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
            'parent'    => 'Nadriadená osoba',
            'pinned'    => 'Pripnuté',
            'role'      => 'Rola',
            'status'    => 'Stav členstva',
        ],
        'helpers'       => [
            'all_members'   => 'Všetky postavy, ktoré sú členmi tejto a podradených organizácií.',
            'members'       => 'Všetky postavy, ktoré sú členmi tejto organizácie',
            'pinned'        => 'Zvoľ, či toto členstvo má byť zobrazené v sekcii pripnutých v prehľade priradených objektov.',
        ],
        'pinned'        => [
            'both'  => 'Oboje',
            'none'  => 'Žiadne',
        ],
        'placeholders'  => [
            'parent'    => 'Kto je nadriadená osoba tohto člena?',
            'role'      => 'veliteľ, členka, veľkňaz, majsterka špiónov',
        ],
        'status'        => [
            'active'    => 'Aktívne členstvo',
            'inactive'  => 'Neaktívne členstvo',
            'unknown'   => 'Neznámy stav',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'kult, gang, bunka revolúcie, fandom',
    ],
    'show'          => [],
];
