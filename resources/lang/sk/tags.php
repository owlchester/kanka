<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Pridať novú kategóriu',
        ],
        'create'        => [
            'title' => 'Pridaj kategóriu k :name',
        ],
        'description'   => 'Objekty priradené kategórii',
        'title'         => 'Podradené kategórie :name',
    ],
    'create'        => [
        'description'   => 'Vytvor novú kategóriu',
        'success'       => 'Kategória :name vytvorená.',
        'title'         => 'Nová kategória',
    ],
    'destroy'       => [
        'success'   => 'Kategória :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Kategória :name upravená.',
        'title'     => 'Upraviť kategóriu :name',
    ],
    'fields'        => [
        'characters'    => 'Postavy',
        'children'      => 'Podradené kategórie',
        'name'          => 'Názov',
        'tag'           => 'Kategória',
        'tags'          => 'Priradené kategórie',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'    => 'Kategórie vieš zoradiť vo vnorenom zobrazení. Kategórie bez nadradenej kategórie sa zobrazia štandardným spôsobom. Kategórie s podradenými kategóriami je možné rozkliknúť, dokiaľ nebudú existovať pod nimi už žiadne ďalšie podradené kategórie.',
    ],
    'hints'         => [
        'children'  => 'Tento zoznam obsahuje všetky objekty priamo pod touto kategóriou a jej podriadenými kategóriami.',
        'tag'       => 'Zobrazené sú všetky kategórie, ktoré sú tejto priamo podriadené.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Vnorené zobrazenie',
        ],
        'add'           => 'Nová kategória',
        'description'   => 'Spravuj kategóriu :name.',
        'header'        => 'Kategórie podradené :name',
        'title'         => 'Kategórie',
    ],
    'new_tag'       => 'Nová kategória',
    'placeholders'  => [
        'name'  => 'Názov kategórie',
        'tag'   => 'Vyber nadradenú kategóriu',
        'type'  => 'mýtus, vojna, historická udalosť, náboženstvo, vexilológia',
    ],
    'show'          => [
        'description'   => 'Detailný náhľad na kategóriu',
        'tabs'          => [
            'children'      => 'Podradené kategórie',
            'information'   => 'Informácie',
            'tags'          => 'Kategórie',
        ],
        'title'         => 'Kategória :name',
    ],
    'tags'          => [
        'description'   => 'Podradené kategórie',
        'title'         => 'Kategórie podradené :name',
    ],
];
