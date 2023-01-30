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
    ],
    'helpers'       => [],
    'index'         => [],
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
