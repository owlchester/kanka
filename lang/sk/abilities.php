<?php

return [
    'abilities'     => [],
    'children'      => [
        'actions'       => [
            'attach'    => 'Pripojiť k objektom',
        ],
        'create'        => [
            'attach_success'    => '{1} Schopnosť :name bola pripojená k :count objektu.|[2,*] Schopnosť :name bola priradená ku :count objektom.',
            'modal'             => 'Pripojiť :name k objektom',
        ],
        'description'   => 'Objekty s touto schopnosťou',
        'title'         => 'Objekty schopnosti :name',
    ],
    'create'        => [
        'title' => 'Nová schopnosť',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [],
    'fields'        => [
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
            'entities'  => 'Objekty',
            'reorder'   => 'Preskúpiť schopnosti',
        ],
    ],
];
