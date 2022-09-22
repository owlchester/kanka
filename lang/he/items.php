<?php

return [
    'create'        => [
        'title' => 'חפץ חדש',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'character' => 'דמות',
        'image'     => 'תמונה',
        'location'  => 'מיקום',
        'name'      => 'שם',
        'price'     => 'מחיר',
        'size'      => 'גודל',
        'type'      => 'סוג',
    ],
    'index'         => [
        'title' => 'חפצים',
    ],
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
