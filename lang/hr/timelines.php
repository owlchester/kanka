<?php

return [
    'actions'       => [
        'add_element'   => 'Dodajte element u razdoblje :era',
        'back'          => 'Povratak na :name',
        'edit'          => 'Uredi kronologiju',
        'save_order'    => 'Spremi novi redoslijed',
    ],
    'create'        => [
        'title' => 'Nova kronologija',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_eras'     => 'Kopiraj razdoblja',
        'eras'          => 'Razdoblja',
        'name'          => 'Naziv',
        'reverse_order' => 'Obrni redoslijed razdoblja',
        'timeline'      => 'Roditeljska kronologija',
        'timelines'     => 'Kronologije',
        'type'          => 'Tip',
    ],
    'helpers'       => [
        'nested_without'    => 'Prikazuju se sve kronologije koje nemaju kronologiju roditelj. Klikni redak da bi vidio/la kronologije djecu.',
        'reverse_order'     => 'Omogući za prikaz razdoblja obrnutim kronološkim redoslijedom (prvo starije ere)',
    ],
    'index'         => [
        'title' => 'Kronologije',
    ],
    'placeholders'  => [
        'name'  => 'Naziv kronologije',
        'type'  => 'Primarna, Svjetska kronika, Ostavština kraljevstva',
    ],
    'show'          => [],
    'timelines'     => [
        'title' => 'Kronologije kronologije :name',
    ],
];
