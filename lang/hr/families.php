<?php

return [
    'create'        => [
        'title' => 'Nova obitelj',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Članovi',
    ],
    'helpers'       => [],
    'hints'         => [
        'members'   => 'Ovdje su navedeni članovi obitelji. Lik se može dodati u obitelj uređivanjem željenog lika, upotrebom padajućeg izbornika "Obitelj".',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Na sljedećem popisu su svi likovi koji se nalaze u ovoj obitelji i sve manjim obiteljima unutar ove obitelji.',
            'direct_members'    => 'Većina obitelji ima članove koji ju vode ili čine poznatom. Sljedeći popis prikazuje likove koji se nalaze u ovoj obitelji.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Ime obitelji',
        'type'  => 'Kraljevska, plemenita, izumrla',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Članovi',
        ],
    ],
];
