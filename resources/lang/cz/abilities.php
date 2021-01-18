<?php

return [
    'abilities'     => [
        'title' => 'Schopnosti přiřazené :name',
    ],
    'create'        => [
        'success'   => 'Schopnost :name vytvořena.',
        'title'     => 'Nová schopnost',
    ],
    'destroy'       => [
        'success'   => 'Schopnost :name odstraněna.',
    ],
    'edit'          => [
        'success'   => 'Schopnost :name upravena.',
        'title'     => 'Upravit schopnost :name',
    ],
    'fields'        => [
        'abilities' => 'Schopbosti',
        'ability'   => 'Schopnost',
        'charges'   => 'Nabití',
        'name'      => 'Jméno',
        'type'      => 'Druh',
    ],
    'helpers'       => [
        'descendants'   => 'Tento seznam obsahuje všechny schopnosti, které jsou pod touto schopbostí a nejen ty, které jsou přířazené přímo k ní.',
        'nested'        => 'Ve vnořeném zobrazení můžeš zobrazit své schopbosti podle nadřazených schopností. Schopnosti bez nadřazené schopnosti se zobrazí standartním způsobem. Schopnosti s podraženými schopbostmi je možné rozkliknout, dokud nebudou existovat žádné další podřazené schopnosti.',
    ],
    'index'         => [
        'add'           => 'Nová schopnost',
        'description'   => 'Vytvoř síly, kouzla, schopnosti a další pro své objekty.',
        'header'        => 'Schopnost',
        'title'         => 'Schopnosti',
    ],
    'placeholders'  => [
        'charges'   => 'Počet nabití. Propoj schopnosti s {Úroveň}*{CHA}',
        'name'      => 'Ohnivá koule, Ve střehu, Zákeřný úder',
        'type'      => 'Kouzlo, schopnost, útok',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Schopnosti',
        ],
    ],
];
