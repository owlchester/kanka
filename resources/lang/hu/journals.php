<?php

return [
    'create'        => [
        'description'   => 'Új naplóbejegyzés létrehozása',
        'success'       => '\':name\' naplóbejegyzést létrehoztuk.',
        'title'         => 'Új naplóbejegyzést',
    ],
    'destroy'       => [
        'success'   => '\':name\' naplóbejegyzést eltávolítottuk.',
    ],
    'edit'          => [
        'success'   => '\':name\' naplóbejegyzést frissítettük.',
        'title'     => ':name naplóbejegyzés szerkesztése',
    ],
    'fields'        => [
        'author'    => 'Szerző',
        'date'      => 'Dátum',
        'image'     => 'Kép',
        'name'      => 'Megnevezés',
        'relation'  => 'Kapcsolat',
        'type'      => 'Típus',
    ],
    'index'         => [
        'add'           => 'Új naplóbejegyzés',
        'description'   => ':name naplóbejegyzéseinek kezelése',
        'header'        => ':name naplóbejegyzései',
        'title'         => 'Naplók',
    ],
    'placeholders'  => [
        'author'    => 'Ki írta a naplóbejegyzést?',
        'date'      => 'A naplóbejegyzés keletkezésének dátuma',
        'name'      => 'A naplóbejegyzés címe',
        'type'      => 'Játékalkalom, egylövetű, vázlat',
    ],
    'show'          => [
        'description'   => 'A naplóbejegyzés részletes nézete',
        'title'         => ':name',
    ],
];
