<?php

return [
    'abilities'     => [
        'title' => 'Schopnosti, podřazené :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Přidat schopnost k objektu',
        ],
        'create'        => [
            'success'   => 'Schopnost :name přidána objektu.',
            'title'     => 'Přidat objekt k :name',
        ],
        'description'   => 'Objekty s touto schopností',
        'title'         => 'Objekty se schopností :name',
    ],
    'create'        => [
        'title' => 'Nová Schopnost',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [
        'title' => 'Objekty se schopností :name',
    ],
    'fields'        => [
        'abilities' => 'Schopnosti',
        'ability'   => 'Nadřazená schopnost',
        'charges'   => 'Počet použití',
    ],
    'helpers'       => [
        'nested_without'    => 'Seznam všech schopností bez nadřazené schopnosti (jsou na vrcholu stromu schopností). Klepnutím na řádek se zobrazí podřazené schopnosti.',
    ],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Počet použití. Odkaz na atributy pomocí {Úroveň}*{CHA}',
        'name'      => 'Ohnivá koule, Ve střehu, Zákeřný úder',
        'type'      => 'Kouzlo, Schopnost, útok',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Schopnosti',
            'entities'  => 'Objekty',
        ],
    ],
];
