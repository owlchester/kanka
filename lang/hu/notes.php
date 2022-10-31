<?php

return [
    'create'        => [
        'title' => 'Új jegyzet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_pinned' => 'Kiemelt',
        'note'      => 'Szülőjegyzet',
        'notes'     => 'Aljegyzet',
    ],
    'helpers'       => [
        'nested_without'    => 'Minden jegyeztet megmutat, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermekjegyzeteket.',
    ],
    'hints'         => [
        'is_pinned' => 'A vezérlőpultra legfeljebb három jegyzetet emelhetsz ki.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'A jegyzet neve',
        'note'  => 'Válassz egy szülőjegyzetet',
        'type'  => 'Vallás, faj, politikai rendszer',
    ],
    'show'          => [],
];
