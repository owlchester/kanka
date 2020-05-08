<?php

return [
    'create'        => [
        'description'   => 'צור יומן חדש',
        'success'       => 'יומן ":name" נוצר.',
        'title'         => 'יומן חדש',
    ],
    'destroy'       => [
        'success'   => 'יומן ":name" הוסר.',
    ],
    'edit'          => [
        'success'   => 'יומן ":name" עודכן.',
        'title'     => 'ערוך יומן :name',
    ],
    'fields'        => [
        'author'    => 'כותב',
        'date'      => 'תאריך',
        'image'     => 'תמונה',
        'name'      => 'שם',
        'relation'  => 'יחסים',
        'type'      => 'סוג',
    ],
    'index'         => [
        'add'           => 'יומן חדש',
        'description'   => 'נהל יומנים של :name',
        'header'        => 'היומנים של :name',
        'title'         => 'יומנים',
    ],
    'placeholders'  => [
        'author'    => 'מי כתב את היומן',
        'date'      => 'התאריך של היומן',
        'name'      => 'השם של היומן',
        'type'      => 'מפגש, חד"פ, טיוטה',
    ],
    'show'          => [
        'description'   => 'מבט מפורט על יומן',
        'title'         => 'יומן :name',
    ],
];
