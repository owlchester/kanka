<?php

return [
    'create'        => [
        'success'   => '\':name\' küldetést létrehoztuk.',
        'title'     => 'Új küldetés',
    ],
    'destroy'       => [
        'success'   => '\':name\' küldetést eltávolítottuk.',
    ],
    'edit'          => [
        'success'   => '\':name\' küldetést frissítettük.',
        'title'     => ':name küldetés szerkesztése',
    ],
    'elements'      => [
        'create'    => [
            'success'   => ':entity entitást hozzáadtuk a küldetéshez.',
            'title'     => ':name új eleme',
        ],
        'destroy'   => [
            'success'   => ':entity küldetéselemét eltávolítottuk.',
        ],
        'edit'      => [
            'success'   => ':entity küldetéselemét frissítettük.',
            'title'     => ':name küldetéselemének firssítése',
        ],
        'fields'    => [
            'description'   => 'Leírás',
            'quest'         => 'Küldetés',
        ],
        'title'     => ':name küldetés elemei',
    ],
    'fields'        => [
        'character'     => 'Küldetésadó',
        'copy_elements' => 'A küldetéshez tartozó elemek másolása',
        'date'          => 'Dátum',
        'description'   => 'Leírás',
        'image'         => 'Kép',
        'is_completed'  => 'Teljesítve',
        'name'          => 'Megnevezés',
        'quest'         => 'Szülő Küldetés',
        'quests'        => 'Alküldetések',
        'role'          => 'Szerep',
        'type'          => 'Típus',
    ],
    'helpers'       => [
        'nested_parent' => ':parent küldetéseinek mutatása',
        'nested_without'=> 'Minden küldetést megmutat, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermekküldetéseit.',
    ],
    'hints'         => [
        'quests'    => 'A főküldetés és az alküldetések mezők használatával összefüggő küldetések hálóját építheted fel.',
    ],
    'index'         => [
        'title' => 'Küldetések',
    ],
    'placeholders'  => [
        'date'  => 'A küldetés valós világbéli dátuma',
        'name'  => 'A küldetés neve',
        'quest' => 'Főküldetés',
        'role'  => 'Az entitás szerepe a küldetésben',
        'type'  => 'Karaktertörténet, mellékszál, főszál',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Elem hozzáadása',
        ],
        'tabs'      => [
            'elements'  => 'Elemek',
        ],
    ],
];
