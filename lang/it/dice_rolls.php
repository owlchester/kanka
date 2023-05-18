<?php

return [
    'create'        => [
        'title' => 'Nuovo Tiro di Dado',
    ],
    'destroy'       => [
        'dice_roll' => 'Tiro di dado rimosso.',
    ],
    'edit'          => [],
    'fields'        => [
        'created_at'    => 'Tirato il',
        'parameters'    => 'Parametri',
        'results'       => 'Risultati',
        'rolls'         => 'Tiri',
    ],
    'hints'         => [
        'parameters'    => 'Quali sono le opzioni per i miei dadi?',
    ],
    'index'         => [
        'actions'   => [
            'results'   => 'Risultati',
        ],
    ],
    'placeholders'  => [
        'name'          => 'Nome del Tiro di Dado',
        'parameters'    => '4d6+3',
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
    ],
];
