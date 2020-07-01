<?php

return [
    'create'        => [
        'description'   => 'צור פתק חדש',
        'success'       => 'הפתק \':name\' נוצר.',
        'title'         => 'פתק חדש',
    ],
    'destroy'       => [
        'success'   => 'הפתק \':name\' הוסר.',
    ],
    'edit'          => [
        'success'   => 'הפתק \':name\' עודכן.',
        'title'     => 'ערוך פתק \':name\'.',
    ],
    'fields'        => [
        'description'   => 'תיאור',
        'image'         => 'תמונה',
        'is_pinned'     => 'מוצמד',
        'name'          => 'שם',
        'type'          => 'סוג',
    ],
    'hints'         => [
        'is_pinned' => 'עד 3 פתקים יכולים להיות מוצמדים לדף הבית של המערכה.',
    ],
    'index'         => [
        'add'           => 'פתק חדש',
        'description'   => 'ניהול הפתקים של :name.',
        'header'        => 'פתקים של :name',
        'title'         => 'פתקים',
    ],
    'placeholders'  => [
        'name'  => 'שם הפתק',
        'type'  => 'דת, גזע, מערכת פוליטית',
    ],
    'show'          => [
        'description'   => 'מבט מפורט על הפתק',
        'tabs'          => [
            'description'   => 'תיאור',
        ],
        'title'         => 'פתק :name',
    ],
];
