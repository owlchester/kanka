<?php

return [
    'create'        => [
        'success'   => 'Kreirano bacanje kockice ":name".',
        'title'     => 'Novo bacanje kockica',
    ],
    'destroy'       => [
        'dice_roll' => 'Uklonjeno bacanje kockica.',
        'success'   => 'Uklonjeno bacanje kockica ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažurirano bacanje kockica ":name".',
        'title'     => 'Uredi bacanje kockica :name',
    ],
    'fields'        => [
        'created_at'    => 'Kockice bačene u',
        'name'          => 'Naziv',
        'parameters'    => 'Parametri',
        'results'       => 'Rezultati',
        'rolls'         => 'Bacanja',
    ],
    'hints'         => [
        'parameters'    => 'Koje su moje opcije kockica?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Bacanja kockica',
            'results'   => 'Rezultati',
        ],
        'title'     => 'Bacanja kockica',
    ],
    'placeholders'  => [
        'dice_roll' => 'Bacanje kockica',
        'name'      => 'Naziv bacanja kockica',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Bacanje',
        ],
        'error'     => 'Bacanje kockica neuspješno. Nije moguće analizirati parametre.',
        'fields'    => [
            'creator'   => 'Kreator',
            'date'      => 'Datum',
            'result'    => 'Rezultat',
        ],
        'hint'      => 'Sva bacanja napravljena za ovaj predložak bacanja kockica.',
        'success'   => 'Kockice bačene.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Rezultati',
        ],
    ],
];
