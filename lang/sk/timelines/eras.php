<?php

return [
    'actions'       => [
        'add'   => 'Pridať nové obdobie',
    ],
    'bulks'         => [
        'delete'    => '{0} Odstránených :count období.|{1} Odstránené :count obdobie.|[2,4] Odstránené :count obdobia.|[5,*] Odstránených :count období.',
    ],
    'create'        => [
        'success'   => 'Obdobie :name vytvorené.',
        'title'     => 'Nové obdobie',
    ],
    'delete'        => [
        'success'   => 'Obdobie :name odstránené.',
    ],
    'edit'          => [
        'success'   => 'Obdobie :name aktualizované.',
        'title'     => 'Upraviť obdobie :name',
    ],
    'fields'        => [
        'abbreviation'  => 'Skratka',
        'end_year'      => 'Koniec (rok)',
        'is_collapsed'  => 'Zbalené',
        'start_year'    => 'Začiatok (rok)',
    ],
    'helpers'       => [
        'eras'          => 'Pred pridávaním období musíš vytvoriť časovú os.',
        'is_collapsed'  => 'Obdobia sú štandardne zbalené (minimalizované).',
        'primary'       => 'Rozdeľ svoju časovú os na obdobia. Časová os vyžaduje min. jedno obdobie, aby správne fungovala.',
    ],
    'index'         => [
        'title' => 'Obdobia časovej osi :name',
    ],
    'placeholders'  => [
        'abbreviation'  => 'pred n.l., po Kr., AD',
        'end_year'      => 'Rok, kedy končí daný vek. Ponechaj prázdny, ak je to aktuálny vek.',
        'name'          => 'Novovek, Doba bronzová, Galaktické vojny',
        'start_year'    => 'Rok, kedy začína daný vek. Ponechaj prázdny, ak je to prvý vek.',
    ],
    'reorder'       => [],
];
