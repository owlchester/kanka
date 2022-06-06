<?php

return [
    'create'        => [
        'title' => 'Új jegyzet',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'description'   => 'Leírás',
        'image'         => 'Kép',
        'is_pinned'     => 'Kiemelt',
        'name'          => 'Név',
        'note'          => 'Szülőjegyzet',
        'notes'         => 'Aljegyzet',
        'type'          => 'Típus',
    ],
    'helpers'       => [
        'nested_parent' => ':parent jegyzeteinek mutatása',
        'nested_without'=> 'Minden jegyeztet megmutat, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermekjegyzeteket.',
    ],
    'hints'         => [
        'is_pinned' => 'A vezérlőpultra legfeljebb három jegyzetet emelhetsz ki.',
    ],
    'index'         => [
        'title' => 'Jegyzetek',
    ],
    'placeholders'  => [
        'name'  => 'A jegyzet neve',
        'note'  => 'Válassz egy szülőjegyzetet',
        'type'  => 'Vallás, faj, politikai rendszer',
    ],
    'show'          => [],
];
