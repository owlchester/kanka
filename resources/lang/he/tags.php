<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'הוסף תג חדש',
        ],
        'create'    => [
            'title' => 'הוסף תג ל:name',
        ],
        'title'     => 'צאצאיים של התג :name',
    ],
    'create'        => [
        'success'   => 'התג \':name\' נוצר.',
        'title'     => 'תג חדש',
    ],
    'destroy'       => [
        'success'   => 'התג \':name\' הוסר.',
    ],
    'edit'          => [
        'success'   => 'התג \':name\' עודכן.',
        'title'     => 'ערוך את התג :name',
    ],
    'fields'        => [
        'children'  => 'צאצאים',
        'name'      => 'שם',
        'tag'       => 'תג-אב',
        'tags'      => 'תת-תגים',
        'type'      => 'סוג',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'רשימה זו כוללת את כל האובייקטים המשוייכים לתג זה ולכל התת-תגים שלו',
        'tag'       => 'כאן מוצגים כל התגים שהם צאצאים ישירים של תג זה.',
    ],
    'index'         => [
        'title' => 'תגים',
    ],
    'new_tag'       => 'תג חדש',
    'placeholders'  => [
        'name'  => 'השם של התג',
        'tag'   => 'בחר תג-אב',
        'type'  => 'סיפור, מלחמות, היסטוריה, דת, ווקסילולוגיה',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'צאצאים',
            'tags'      => 'תגים',
        ],
    ],
    'tags'          => [
        'title' => 'צאצאיים של :name',
    ],
];
