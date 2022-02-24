<?php

return [
    'abilities'     => [
        'title' => 'צאצאים של :name',
    ],
    'create'        => [
        'success'   => 'היכולת \':name\' נוצרה.',
        'title'     => 'יכולת חדשה',
    ],
    'destroy'       => [
        'success'   => 'היכולת \':name\' הוסרה.',
    ],
    'edit'          => [
        'success'   => 'היכולת \':name\' עודכנה.',
        'title'     => 'ערוך יכולת \':name\'',
    ],
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
        'add'       => 'יכולת חדשה',
        'header'    => 'היכולות של :name',
        'title'     => 'יכולות',
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
        'title' => 'יכולת :name',
    ],
];
