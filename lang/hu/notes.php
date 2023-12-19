<?php

return [
    'create'        => [
        'title' => 'Új jegyzet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Aljegyzet',
    ],
    'helpers'       => [
        'nested_without'    => 'Minden jegyeztet megmutat, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermekjegyzeteket.',
    ],
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Válassz egy szülőjegyzetet',
        'type'  => 'Vallás, faj, politikai rendszer',
    ],
    'show'          => [],
];
