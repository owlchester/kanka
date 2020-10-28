<?php

return [
    'actions'       => [
        'return'        => 'Povratak na sve događaje',
        'send'          => 'Sudjeluj',
        'show_ongoing'  => 'Pogledaj događaj i sudjeluj',
        'show_past'     => 'Pogledaj događaj i pobjednike',
        'update'        => 'Ažuriraj prijavu',
        'view'          => 'Pogledaj prijavu',
    ],
    'description'   => 'Održavamo česte događaje gradnje svijeta za našu zajednicu i predstavljamo nama omiljene unose.',
    'fields'        => [
        'comment'       => 'Komentar',
        'entity_link'   => 'Veza do entiteta',
        'rank'          => 'Rang',
        'submitter'     => 'Podnositelj',
    ],
    'index'         => [
        'ongoing'   => 'Tekući događaji',
        'past'      => 'Prošli događaji',
    ],
    'participate'   => [
        'description'   => 'Osjećaš li se nadahnuto ovim događajem? Stvori entitet u jednoj od svojih javnih kampanja i pošalji nam vezu do entiteta u donjem obrascu. Podneseni zahtjev možeš promijeniti ili izbrisati u bilo kojem trenutku.',
        'login'         => 'Prijavi se u svoj račun da bi sudjelovao/la u događaju.',
        'participated'  => 'Već si poslao/la prijavu za ovaj događaj. Možeš ga urediti ili ukloniti.',
        'success'       => [
            'modified'  => 'Promjene u tvojoj prijavi su spremljene.',
            'removed'   => 'Tvoja prijava je uklonjena.',
            'submit'    => 'Tvoja prijava je poslana. Možeš ju urediti ili ukloniti u bilo kojem trenutku.',
        ],
        'title'         => 'Sudjeluj u događaju',
    ],
    'placeholders'  => [
        'comment'       => 'Komentar u vezi s tvojom prijavom (neobavezno)',
        'entity_link'   => 'Zalijepi kopiranu poveznicu do entiteta ovdje',
    ],
    'results'       => [
        'description'       => 'Naš je žiri odabrao sljedeće prijave kao pobjednike za događaj.',
        'title'             => 'Pobjednici događaja',
        'waiting_results'   => 'Događaj je završen! Žiri događaja će razmotriti prijave, a čim se odaberu pobjednici, oni će biti prikazani ovdje.',
    ],
    'show'          => [
        'participants'  => '{1} :number prijava predana.|[2,4] :number prijave predane.|[5,*] :number prijava predano.',
        'title'         => 'Događaj :name',
    ],
    'title'         => 'Događaji',
];
