<?php

return [
    'abilities'     => [
        'title' => 'צאצאים של :name',
    ],
    'create'        => [
        'title' => 'יכולת חדשה',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'abilities' => 'יכולות',
        'ability'   => 'יכולת',
        'charges'   => 'שימושים',
        'name'      => 'שם',
        'type'      => 'סוג',
    ],
    'helpers'       => [
        'descendants'   => 'זוהי רשימה של כל היכולות שנחשבות צאצאים של היכולת הזו, לא רק הצאצאים הישירים שלה.',
    ],
    'index'         => [
        'title' => 'יכולות',
    ],
    'placeholders'  => [
        'charges'   => 'מספר שימושים. אפשר להתייחס לתכונות עם {Level} * {CHA}',
        'name'      => 'כדור אש, מודעות, מתקפת פתע',
        'type'      => 'לחש, כשרון, התקפה',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'יכולות',
        ],
    ],
];
