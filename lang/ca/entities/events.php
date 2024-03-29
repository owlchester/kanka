<?php

return [
    'fields'    => [
        'type'  => 'Tipus d\'esdeveniment',
    ],
    'helpers'   => [
        'characters'    => 'En seleccionar una data de naixement o de mort, l\'edat d\'aquest personatge es calcularà automàticament. :more',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Afegeix un recordatori',
        ],
        'title'     => 'Recordatoris de :name',
    ],
    'types'     => [
        'birth'     => 'Naixement',
        'death'     => 'Mort',
        'primary'   => 'Primari',
    ],
];
