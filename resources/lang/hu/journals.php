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
        'journal'   => 'Szülőnapló',
        'journals'  => 'Alnaplók',
        'name'      => 'Megnevezés',
        'relation'  => 'Kapcsolat',
        'type'      => 'Típus',
    ],
    'helpers'       => [
        'journals'      => 'Az összes vagy csak a közvetlen alnaplók mutatása',
        'nested_parent' => ':parent naplóinak mutatása',
        'nested_without'=> 'Minden olyan napló megmutatása, amelynek nincs szülőnaplója. Klikkelj egy sorra, hogy lásd a gyermeknaplókat.',
    ],
    'index'         => [
        'add'           => 'Új naplóbejegyzés',
        'description'   => ':name naplóbejegyzéseinek kezelése',
        'header'        => ':name naplóbejegyzései',
        'title'         => 'Naplók',
    ],
    'journals'      => [
        'title' => ':name napló alnaplói',
    ],
    'placeholders'  => [
        'author'    => 'Ki írta a naplóbejegyzést?',
        'date'      => 'A naplóbejegyzés keletkezésének dátuma',
        'journal'   => 'Válassz szülőnaplót',
        'name'      => 'A naplóbejegyzés címe',
        'type'      => 'Játékalkalom, egylövetű, vázlat',
    ],
    'show'          => [
        'description'   => 'A naplóbejegyzés részletes nézete',
        'tabs'          => [
            'journals'  => 'Naplók',
        ],
        'title'         => ':name',
    ],
];
