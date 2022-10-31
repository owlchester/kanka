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
        'title' => 'Nová kategória',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Podradené kategórie',
        'is_auto_applied'   => 'Automaticky nastaviť pre nové objekty',
        'tag'               => 'Kategória',
        'tags'              => 'Priradené kategórie',
    ],
    'helpers'       => [
        'nested_without'    => 'Zobrazujú sa všetky kategórie, ktoré nemajú nadradenú kategóriu. Kliknutím na riadok zobrazíš podradené kategórie.',
        'no_children'       => 'Aktuálne nemá túto kategóriu pridelený žiaden objekt.',
    ],
    'hints'         => [
        'children'          => 'Tento zoznam obsahuje všetky objekty priamo pod touto kategóriou a jej podriadenými kategóriami.',
        'is_auto_applied'   => 'Aktivuj toto nastavenie, ak chceš, aby bola táto kategória automaticky pri novo vytvorených objektoch.',
        'tag'               => 'Zobrazené sú všetky kategórie, ktoré sú tejto priamo podriadené.',
    ],
    'index'         => [],
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
    ],
    'tags'          => [
        'title' => 'Kategórie podradené :name',
    ],
];
