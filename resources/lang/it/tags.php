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
        'success'   => 'Tag \':name\' creato.',
        'title'     => 'Nuovo Tag',
    ],
    'destroy'       => [
        'success'   => 'Tag \':name\' rimosso.',
    ],
    'edit'          => [
        'success'   => 'Tag \':name\' aggiornato.',
        'title'     => 'Modifica il Tag :name',
    ],
    'fields'        => [
        'children'  => 'Figli',
        'name'      => 'Nome',
        'tag'       => 'Tag',
        'tags'      => 'Sotto-Tag',
        'type'      => 'Tipo',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Questa lista contiene tutte le entità direttamente assegnate a questo tag ed in tuuìtti i tad discendenti.',
        'tag'       => 'Visualizzati sotto vi sono tutti i tag che sono direttamente sotto a questo.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'Visualizzazione annidata',
        ],
        'add'       => 'Nuovo tag',
        'header'    => 'Tags per :name',
        'title'     => 'Tags',
    ],
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
        'title' => 'Tag :name',
    ],
    'tags'          => [
        'title' => 'Discendente del tag :name',
    ],
];
