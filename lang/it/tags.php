<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Aggiungi un nuovo tag',
        ],
        'create'    => [
            'success'   => 'Aggiungi il tag :name all\'entità',
            'title'     => 'Aggiungi un tag a :name',
        ],
        'title'     => 'Discendente del tag :name',
    ],
    'create'        => [
        'title' => 'Nuovo Tag',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Figli',
        'tag'       => 'Tag',
        'tags'      => 'Sotto-Tag',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Questa lista contiene tutte le entità direttamente assegnate a questo tag ed in tuuìtti i tad discendenti.',
        'tag'       => 'Visualizzati sotto vi sono tutti i tag che sono direttamente sotto a questo.',
    ],
    'index'         => [],
    'new_tag'       => 'Nuovo Tag',
    'placeholders'  => [
        'name'  => 'Nome del tag',
        'tag'   => 'Seleziona un tag genitore',
        'type'  => 'Tradizioni, Guerre, Storia, Religione, Araldica',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Figlio',
            'tags'      => 'Tags',
        ],
    ],
    'tags'          => [
        'title' => 'Discendente del tag :name',
    ],
];
