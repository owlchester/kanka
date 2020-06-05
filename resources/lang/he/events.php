<?php

return [
    'create'        => [
        'description'   => 'צור אירוע חדש',
        'success'       => 'האירוע \':name\' נוצר.',
        'title'         => 'אירוע חדש',
    ],
    'destroy'       => [
        'success'   => 'האירוע \':name\' הוסר.',
    ],
    'edit'          => [
        'success'   => 'האירוע \':name\' עודכן.',
        'title'     => 'ערוך אירוע :name',
    ],
    'fields'        => [
        'date'      => 'תאריך',
        'image'     => 'תמונה',
        'location'  => 'מיקום',
        'name'      => 'שם',
        'type'      => 'סוג',
    ],
    'index'         => [
        'add'           => 'אירוע חדש',
        'description'   => 'נהל את האירועים של :name.',
        'header'        => 'האירועים של :name',
        'title'         => 'אירועים',
    ],
    'placeholders'  => [
        'date'      => 'התאריך של האירוע',
        'location'  => 'בחר מיקום',
        'name'      => 'השם של האירוע',
        'type'      => 'טקס, חג, אסון, קרב, לידה',
    ],
    'show'          => [
        'description'   => 'מבט מפורט על אירוע',
        'tabs'          => [
            'information'   => 'מידע',
        ],
        'title'         => 'אירוע :name',
    ],
    'tabs'          => [
        'calendars' => 'מופעים בלוחות שנה',
    ],
];
