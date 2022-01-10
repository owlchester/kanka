<?php

return [
    'create'        => [
        'description'   => 'Vytvoriť novú organizáciu',
        'success'       => 'Organizácia :name vytvorená.',
        'title'         => 'Nová organizácia',
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
        'relation'      => 'Prepojenie',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Tento zoznam obsahuje všetky organizácie, ktoré sú podradené tejto a všetkým podradeným organizáciám.',
        'nested'        => 'Vo vnorenom zobrazení vieš zoradiť tvoje organizácie podľa nadradených organizácií. Organizácie bez nadradenej sa zoradia štandardným spôsobom. Organizácie s podradenými je možné rozkliknúť, dokiaľ nebudú existovať už žiadne ďalšie podradené organizácie.',
        'nested_parent' => 'Zobraziť organizácie :parent.',
        'nested_without'=> 'Zobraziť všetky organizácie, ktoré nemajú nadradenú organizáciu. Kliknutím na riadok zobrazíš podradené organizácie.',
    ],
    'index'         => [
        'add'           => 'Nová organizácia',
        'description'   => 'Spravuj organizácie objektu :name.',
        'header'        => 'Organizácie objektu :name',
        'title'         => 'Organizácie',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Pridať člena',
        ],
        'create'        => [
            'description'   => 'Pridaj člena do organizácie',
            'success'       => 'Člen pridaný do organizácie.',
            'title'         => 'Nový člen organizácie :name',
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
            'role'      => 'veliteľ, člen, veľkňaz, majster špiónov',
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
    'quests'        => [
        'description'   => 'Úlohy organizácie',
        'title'         => 'Úlohy organizácie :name',
    ],
    'show'          => [
        'description'   => 'Detailný náhľad organizácie',
        'tabs'          => [
            'organisations' => 'Organizácie',
            'quests'        => 'Úlohy',
            'relations'     => 'Prepojenia',
        ],
        'title'         => 'Organizácia :name',
    ],
];
