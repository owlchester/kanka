<?php

return [
    'sync'  => [
        'actions'   => [
            'sync'  => 'Sincronizza',
        ],
        'errors'    => [
            'invalid_uuid'  => 'Id campagna LFGM non valido. Per favore ritenta.',
        ],
        'helper'    => 'Seleziona una campagna per sincronizzare i tuoi prossimi eventi da :lfgm. Ciò aggiungerà una Nota con i tuoi prossimi eventi a quella campagna e lo fisserà alla sua bacheca.',
        'successes' => [
            'sync'  => 'Calendario LFGM sincronizzato.',
        ],
        'title'     => 'Sincronizzazione Campagna LookingForGM.com',
    ],
];
