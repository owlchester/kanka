<?php

return [
    'characters'    => [
        'description'   => 'דמויות השייכות לגזע',
        'title'         => 'דמויות :race',
    ],
    'create'        => [
        'description'   => 'צור גזע חדש',
        'success'       => 'הגזע \':name\' נוצר.',
        'title'         => 'גזע חדש',
    ],
    'destroy'       => [
        'success'   => 'הגזע \':name\' הוסר.',
    ],
    'edit'          => [
        'success'   => 'הגזע \':name\' עודכן.',
        'title'     => 'ערוך גזע \':name\'',
    ],
    'fields'        => [
        'characters'    => 'דמויות',
        'name'          => 'שם',
        'race'          => 'גזע אב',
        'races'         => 'תתי-גזע',
        'type'          => 'סוג',
    ],
    'helpers'       => [
        'nested'    => 'בצפייה מקוננת, גזעים בלי גזע אב יופיעו בהתחלה. לחיצה על גזע עם תתי-גזעים תציג את הצאצאים. ניתן להמשיך עד שלא נשארים צאצאים לצפייה.',
    ],
    'index'         => [
        'add'           => 'גזע חדש',
        'description'   => 'נהל את הגזעים של :name.',
        'header'        => 'גזעים של :name',
        'title'         => 'גזעים',
    ],
    'placeholders'  => [
        'name'  => 'שם הגזע',
        'type'  => 'בן אנוש, פיה, סייבורג',
    ],
    'races'         => [
        'description'   => 'גזעים השייכים לגזע.',
        'title'         => 'תתי-גזע של :name',
    ],
    'show'          => [
        'description'   => 'מבט מפורט על הגזע',
        'tabs'          => [
            'characters'    => 'דמויות',
            'menu'          => 'תפריט',
            'races'         => 'תתי-גזע',
        ],
        'title'         => 'גזע :name',
    ],
];
