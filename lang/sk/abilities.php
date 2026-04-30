<?php

return [
    'abilities'     => [],
    'children'      => [
        'actions'       => [
            'attach'    => 'Pripojiť k objektom',
        ],
        'create'        => [
            'attach_success'    => '{1} Schopnosť :name bola pripojená k :count objektu.|[2,*] Schopnosť :name bola priradená ku :count objektom.',
            'helper'            => 'Pripojiť :name k jednému alebo viacerým objektom.',
            'title'             => 'Pripojiť objekty',
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
    'helpers'       => [],
    'index'         => [],
    'lists'         => [
        'empty' => 'Pridaj sily, kúzla či talenty. Používa sa na najmä na modelovanie D&D archetypov.',
    ],
    'placeholders'  => [
        'charges'   => 'Počet nábojov. Prepoj atribúty cez {Úroveň}*{CHA}',
        'name'      => 'Ohnivá guľa, Stále v strehu, Zákerný výpad',
        'type'      => 'Kúzlo, schopnosť, útočný manéver',
    ],
    'reorder'       => [
        'parentless'    => 'Bez nadradenej',
        'success'       => 'Schopnosti úspešne usporiadané.',
        'title'         => 'Usporiadanie schopností',
    ],
    'show'          => [
        'tabs'  => [
            'reorder'   => 'Usporiadať schopnosti',
        ],
    ],
];
