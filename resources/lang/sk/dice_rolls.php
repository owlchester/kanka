<?php

return [
    'create'        => [
        'success'   => 'Hod kockami \':name\' vytvorený.',
        'title'     => 'Nový hod kockami',
    ],
    'destroy'       => [
        'dice_roll' => 'Hod kockami odstránený.',
        'success'   => 'Hod kockami \':name\' odstránený.',
    ],
    'edit'          => [
        'success'   => 'Hod kockami \':name\' aktualizovaný.',
        'title'     => 'Upraviť hod kociek :name',
    ],
    'fields'        => [
        'created_at'    => 'Hodený',
        'name'          => 'Názov',
        'parameters'    => 'Parametre',
        'results'       => 'Výsledky',
        'rolls'         => 'Hody',
    ],
    'hints'         => [
        'parameters'    => 'Aké možnosti kociek mám?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Hody kockami',
            'results'   => 'Výsledky',
        ],
        'title'     => 'Hody kockami',
    ],
    'placeholders'  => [
        'dice_roll' => 'Hod kockami',
        'name'      => 'Názov hodu kockami',
        'parameters'=> '4d6+3',
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
