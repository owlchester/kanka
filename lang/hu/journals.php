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
    ],
    'helpers'       => [
        'journals'          => 'Az összes vagy csak a közvetlen alnaplók mutatása',
        'nested_without'    => 'Minden olyan napló megmutatása, amelynek nincs szülőnaplója. Klikkelj egy sorra, hogy lásd a gyermeknaplókat.',
    ],
    'index'         => [],
    'journals'      => [],
    'placeholders'  => [
        'author'    => 'Ki írta a naplóbejegyzést?',
        'date'      => 'A naplóbejegyzés keletkezésének dátuma',
        'type'      => 'Játékalkalom, egylövetű, vázlat',
    ],
    'show'          => [],
];
