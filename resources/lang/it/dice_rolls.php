<?php

return [
    'create'        => [
        'success'   => 'Tiro di Dado \':name\' creato.',
        'title'     => 'Nuovo Tiro di Dado',
    ],
    'destroy'       => [
        'dice_roll' => 'Tiro di dado rimosso.',
        'success'   => 'Tiro di Dado \':name\' rimosso.',
    ],
    'edit'          => [
        'success'   => 'Tiro di Dado \':name\' aggiornato.',
        'title'     => 'Modifica il Tiro di Dadi :name',
    ],
    'fields'        => [
        'created_at'    => 'Tirato il',
        'name'          => 'Nome',
        'parameters'    => 'Parametri',
        'results'       => 'Risultati',
        'rolls'         => 'Tiri',
    ],
    'hints'         => [
        'parameters'    => 'Quali sono le opzioni per i miei dadi?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Titi di Dado',
            'results'   => 'Risultati',
        ],
        'add'       => 'Nuovo Tiro di Dado',
        'header'    => 'Tiri di Dado di :name',
        'title'     => 'Tiri di Dado',
    ],
    'placeholders'  => [
        'dice_roll' => 'Tiro di Dado',
        'name'      => 'Nome del Tiro di Dado',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Tira',
        ],
        'error'     => 'Tiro di dado fallito. Impossibile analizzare i parametri.',
        'fields'    => [
            'creator'   => 'Creatore',
            'date'      => 'Data',
            'result'    => 'Risultato',
        ],
        'hint'      => 'Tutti i tiri effettuati per questo template di tiro di dado.',
        'success'   => 'Dado tirato.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Risultati',
        ],
        'title' => 'Tiro di Dado :name',
    ],
];
