<?php

return [
    'fields'    => [
        'type'  => 'Typ události',
    ],
    'helpers'   => [
        'characters'    => 'Pokud nastavíš typ události jako datum narození nebo úmrtí postavy, systém automaticky spočítá věk postavy. :more.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Přidat připomínku',
        ],
        'title'     => 'Připomínky :name',
    ],
    'types'     => [
        'birth'     => 'Narození',
        'death'     => 'Úmrtí',
        'primary'   => 'Hlavní',
    ],
];
