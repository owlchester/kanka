<?php

return [
    'create'        => [
        'description'   => 'צור גלגול חדש',
        'success'       => 'גלגול \':name\' נוצר.',
        'title'         => 'גלגול חדש',
    ],
    'destroy'       => [
        'dice_roll' => 'הגלגול הוסר',
        'success'   => 'הגלגול \':name\' הוסר.',
    ],
    'edit'          => [
        'description'   => 'ערוך גלגול',
        'success'       => 'הגלגול \':name\' עודכן.',
        'title'         => 'ערוך גלגול :name',
    ],
    'fields'        => [
        'created_at'    => 'גולגל ב',
        'name'          => 'שם',
        'parameters'    => 'פרמטרים',
        'results'       => 'תוצאות',
        'rolls'         => 'הטלות',
    ],
    'hints'         => [
        'parameters'    => 'מה האפשרויות לקבויות?',
    ],
    'index'         => [
        'actions'       => [
            'dice'      => 'גלגולים',
            'results'   => 'תוצאות',
        ],
        'add'           => 'גלגול חדש',
        'description'   => 'נהל את הגלגולים של :name',
        'header'        => 'גלגולים של :name',
        'title'         => 'גלגולי קוביות',
    ],
    'placeholders'  => [
        'dice_roll' => 'גלגול',
        'name'      => 'שם הגלגול',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'הטל',
        ],
        'error'     => 'הטלת הקוביות נכשלה. לא ניתן לפרש את הפרמטרים.',
        'fields'    => [
            'creator'   => 'יוצר',
            'date'      => 'תאריך',
            'result'    => 'תוצאה',
        ],
        'hint'      => 'כל ההטלות של גלגולים מתבנית זו.',
        'success'   => 'ההטלה בוצעה.',
    ],
    'show'          => [
        'description'   => 'מבט מפורט על גלגול.',
        'tabs'          => [
            'results'   => 'תוצאה',
        ],
        'title'         => 'גלגול :name',
    ],
];
