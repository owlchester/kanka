<?php

return [
    'create'        => [
        'title' => 'Új naplóbejegyzést',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Szerző',
        'date'      => 'Dátum',
        'image'     => 'Kép',
        'journal'   => 'Szülőnapló',
        'journals'  => 'Alnaplók',
        'name'      => 'Megnevezés',
        'type'      => 'Típus',
    ],
    'helpers'       => [
        'journals'      => 'Az összes vagy csak a közvetlen alnaplók mutatása',
        'nested_parent' => ':parent naplóinak mutatása',
        'nested_without'=> 'Minden olyan napló megmutatása, amelynek nincs szülőnaplója. Klikkelj egy sorra, hogy lásd a gyermeknaplókat.',
    ],
    'index'         => [
        'title' => 'Naplók',
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
        'tabs'  => [
            'journals'  => 'Naplók',
        ],
    ],
];
