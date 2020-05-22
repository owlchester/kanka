<?php

return [
    'abilities'     => [
        'title' => 'Schopnosti priradené :name',
    ],
    'create'        => [
        'success'   => 'Schopnosť :name vytvorená.',
        'title'     => 'Nová schopnosť',
    ],
    'destroy'       => [
        'success'   => 'Schopnosť :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Schopnosť :name upravená.',
        'title'     => 'Upraviť schopnosť :name',
    ],
    'fields'        => [
        'abilities' => 'Schopnosti',
        'ability'   => 'Schopnosť',
        'charges'   => 'Náboje',
        'name'      => 'Názov',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Tento zoznam obsahuje všetky schopnosti, ktoré sú pod touto schopnosťou a nielen tie, ktoré sú priradené len priamo nej.',
        'nested'        => 'Vo vnorenom zobrazení vieš zoradiť tvoje schopnosti podľa nadradených schopností. Schopnosti bez nadradenej schopnosti sa zoradia štandardným spôsobom. Schopnosti s podradenými schopnosťami je možné rozkliknúť, dokiaľ nebudú existovať už žiadne ďalšie podradené schopnosti.',
    ],
    'index'         => [
        'add'           => 'Nová schopnosť',
        'description'   => 'Vytvor sily, kúzla, črty a omnoho viac pre tvoje objekty.',
        'header'        => 'Schopnosti objektu :name',
        'title'         => 'Schopnosti',
    ],
    'placeholders'  => [
        'charges'   => 'Počet nábojov. Prepoj atribúty cez {Úroveň}*{CHA}',
        'name'      => 'Ohnivá guľa, Stále v strehu, Zákerný výpad',
        'type'      => 'Kúzlo, schopnosť, útočný manéver',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Schopnosti',
        ],
        'title' => 'Schopnosť :name',
    ],
];
