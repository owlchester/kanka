<?php

return [
    'abilities'     => [],
    'children'      => [
        'actions'       => [
            'attach'    => 'Dodaj elementom',
        ],
        'create'        => [
            'attach_success'    => '{1} Zdolność :name dodano :count elementowi. |[2,*] Zdolność :name dodano :count elementom.',
            'helper'            => 'Dodaje :name jednemu lub wielu elementom.',
            'title'             => 'Dodawanie elementom',
        ],
        'description'   => 'Elementy posiadające tę zdolność',
        'title'         => 'Elementy zdolności :name',
    ],
    'create'        => [
        'title' => 'Nowa zdolność',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [],
    'fields'        => [
        'charges'   => 'Ładunki',
    ],
    'helpers'       => [],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Liczba ładunków zdolności. Możesz wpisać wartość cechy jako {Level}*{CHA}',
        'name'      => 'Kula ognia, alarm, podstępny atak',
        'type'      => 'Czar, umiejętność, technika bojowa',
    ],
    'reorder'       => [
        'parentless'    => 'Bez źródła',
        'success'       => 'Zmieniono kolejność zdolności.',
        'title'         => 'Zmień kolejność zdolności',
    ],
    'show'          => [
        'tabs'  => [
            'entities'  => 'Elementy',
            'reorder'   => 'Zmień kolejność',
        ],
    ],
];
