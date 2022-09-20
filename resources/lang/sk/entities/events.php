<?php

return [
    'fields'    => [
        'type'  => 'Typ udalosti',
    ],
    'helpers'   => [
        'characters'    => 'Ak nastavíš typ ako dátum narodenia alebo smrti, systém vypočíta automaticky pre túto postavu jej vek. :more',
        'founding'      => 'Nastavením typu ako :type sa automaticky prepočíta vek objektu od jeho založenia.',
        'no_events'     => 'Rozhranie zobrazuje všetky kalendáre, v ktorých sa vyskytujú pripomienky prepojené s týmto objektom.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Pridať pripomienku',
        ],
        'title'     => 'Pripomienky :name',
    ],
    'types'     => [
        'birth'     => 'Narodenie',
        'death'     => 'Smrť',
        'founded'   => 'Založenie',
        'primary'   => 'Primárny',
    ],
    'years-ago' => 'pred {1} :count rokom|[2,*] :count rokmi',
];
