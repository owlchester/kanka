<?php

return [
    'abilities'     => [
        'title' => 'Schopnosti priradené :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Priradiť schopnosť k objektu',
        ],
        'create'        => [
            'success'   => 'Schopnosť :name priradená k objektu.',
            'title'     => 'Priradiť objekt k :name',
        ],
        'description'   => 'Objekty s touto schopnosťou',
        'title'         => 'Objekty schopnosti :name',
    ],
    'create'        => [
        'title' => 'Nová schopnosť',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [
        'title' => 'Objekty so schopnosťou :name',
    ],
    'fields'        => [
        'abilities' => 'Schopnosti',
        'ability'   => 'Schopnosť',
        'charges'   => 'Náboje',
    ],
    'helpers'       => [
        'nested_without'    => 'Zobrazujú sa všetky schopnosti, ktoré nemajú nadradenú schopnosť. Kliknutím na riadok zobrazíš podradené schopnosti.',
    ],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Počet nábojov. Prepoj atribúty cez {Úroveň}*{CHA}',
        'name'      => 'Ohnivá guľa, Stále v strehu, Zákerný výpad',
        'type'      => 'Kúzlo, schopnosť, útočný manéver',
    ],
    'reorder'       => [
        'parentless'    => 'Bez nadradenej',
        'success'       => 'Schopnosti úspešne preskupené.',
        'title'         => 'Preskupenie schopností',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Schopnosti',
            'entities'  => 'Objekty',
            'reorder'   => 'Preskúpiť schopnosti',
        ],
    ],
];
