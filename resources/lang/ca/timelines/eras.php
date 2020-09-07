<?php

return [
    'actions'       => [
        'add'   => 'Afegeix una nova era',
    ],
    'create'        => [
        'success'   => 'S\'ha creat l\'era «:name».',
        'title'     => 'Nova era',
    ],
    'delete'        => [
        'success'   => 'S\'ha eliminat l\'era «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat l\'era «:name».',
        'title'     => 'Edita l\'era :name',
    ],
    'fields'        => [
        'abbreviation'  => 'Abreviatura',
        'end_year'      => 'Any final',
        'start_year'    => 'Any inicial',
    ],
    'helpers'       => [
        'eras'      => 'Cal crear la línia de temps per a poder afegir-hi eres.',
        'primary'   => 'Separa la línia de temps en eres. Una línia de temps necessita almenys una era per a funcionar correctament.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'a.C., d.C., BCE...',
        'end_year'      => 'Any en què acaba l\'era. Deixeu-ho en blanc si aquesta és l\'era actual.',
        'name'          => 'Era moderna, edat del bronze, guerres galàctiques...',
        'start_year'    => 'Any en què l\'era comença. Deixeu-ho en blanc si aquesta és la primera era.',
    ],
    'reorder'       => [
        'success'   => 'S\'han reordenat els elements de l\'era :era.',
    ],
];
