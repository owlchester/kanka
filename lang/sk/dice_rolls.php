<?php

return [
    'create'        => [
        'title' => 'Nový hod kockami',
    ],
    'destroy'       => [
        'dice_roll' => 'Hod kockami odstránený.',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Hodený',
        'parameters'    => 'Parametre',
        'results'       => 'Výsledky',
        'rolls'         => 'Hody',
    ],
    'hints'         => [
        'parameters'    => 'Aké možnosti kociek mám?',
    ],
    'index'         => [
        'actions'   => [
            'results'   => 'Výsledky',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Názov hodu kockami',
        'parameters'    => '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Hod',
        ],
        'error'     => 'Hod kockami neúspešný. Nie je možné spracovať parametre.',
        'fields'    => [
            'creator'   => 'Vytvorené',
            'date'      => 'Dátum',
            'result'    => 'Výsledok',
        ],
        'hint'      => 'Všetky hody vykonané s touto šablónou hodu kockami.',
        'success'   => 'Kocky boli hodené.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Výsledky',
        ],
    ],
];
