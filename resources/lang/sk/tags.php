<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Pridať novú kategóriu',
        ],
        'create'    => [
            'success'   => 'Kategória :name bola priradená objektu.',
            'title'     => 'Pridaj kategóriu k :name',
        ],
        'title'     => 'Podradené kategórie :name',
    ],
    'create'        => [
        'success'   => 'Kategória :name vytvorená.',
        'title'     => 'Nová kategória',
    ],
    'destroy'       => [
        'success'   => 'Kategória :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Kategória :name upravená.',
        'title'     => 'Upraviť kategóriu :name',
    ],
    'fields'        => [
        'children'  => 'Podradené kategórie',
        'name'      => 'Názov',
        'tag'       => 'Kategória',
        'tags'      => 'Priradené kategórie',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'nested_parent' => 'Zobraziť kategórie :parent.',
        'nested_without'=> 'Zobrazujú sa všetky kategórie, ktoré nemajú nadradenú kategóriu. Kliknutím na riadok zobrazíš podradené kategórie.',
    ],
    'hints'         => [
        'children'  => 'Tento zoznam obsahuje všetky objekty priamo pod touto kategóriou a jej podriadenými kategóriami.',
        'tag'       => 'Zobrazené sú všetky kategórie, ktoré sú tejto priamo podriadené.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'Vnorené zobrazenie',
        ],
        'add'       => 'Nová kategória',
        'header'    => 'Kategórie podradené :name',
        'title'     => 'Kategórie',
    ],
    'new_tag'       => 'Nová kategória',
    'placeholders'  => [
        'name'  => 'Názov kategórie',
        'tag'   => 'Vyber nadradenú kategóriu',
        'type'  => 'mýtus, vojna, historická udalosť, náboženstvo, vexilológia',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Podradené kategórie',
            'tags'      => 'Kategórie',
        ],
        'title' => 'Kategória :name',
    ],
    'tags'          => [
        'title' => 'Kategórie podradené :name',
    ],
];
