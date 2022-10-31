<?php

return [
    'create'        => [
        'title' => 'חפץ חדש',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'דמות',
        'price'     => 'מחיר',
        'size'      => 'גודל',
    ],
    'index'         => [],
    'inventories'   => [
        'title' => 'רשימות חפצים של :name',
    ],
    'placeholders'  => [
        'name'  => 'שם החפץ',
        'price' => 'מחיר החפץ',
        'size'  => 'גודל, משקל, מידות',
        'type'  => 'נשק, שיקוי, ארטיפקט',
    ],
    'show'          => [
        'tabs'  => [
            'inventories'   => 'רשימות ציוד',
        ],
    ],
];
