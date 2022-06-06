<?php

return [
    'create'        => [
        'title' => 'פתק חדש',
    ],
    'destroy'       => [],
    'edit'          => [],
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
        'title' => 'פתקים',
    ],
    'placeholders'  => [
        'name'  => 'שם הפתק',
        'type'  => 'דת, גזע, מערכת פוליטית',
    ],
    'show'          => [],
];
