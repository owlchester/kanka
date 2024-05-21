<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Aggiungi un nuovo tag',
        ],
    ],
    'create'        => [
        'title' => 'Nuovo Tag',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Figli',
        'is_auto_applied'   => 'Applica automaticamente alle nuove entità',
        'is_hidden'         => 'Nascosto dall\'intestazione e dal tooltip',
    ],
    'helpers'       => [
        'no_children'   => 'Al momento non ci sono entità con questo tag.',
    ],
    'hints'         => [
        'children'          => 'Questa lista contiene tutte le entità direttamente assegnate a questo tag ed in tuuìtti i tad discendenti.',
        'is_auto_applied'   => 'Seleziona questa opzione per applicare automaticamente questo tag alle entità appena create.',
        'is_hidden'         => 'Se selezionato, questo tag non sarà visualizzato nell\'intestazione o nel tooltip di un\'entità.',
        'tag'               => 'Visualizzati sotto vi sono tutti i tag che sono direttamente sotto a questo.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Tradizioni, Guerre, Storia, Religione, Araldica',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Figlio',
        ],
    ],
    'tags'          => [],
    'transfer'      => [
        'description'   => 'Sposta le entità di questo tag in un altro tag.',
        'fail'          => 'Impossibile trasferire le entità da :tag a :newTag',
        'success'       => 'Spostate con successo le entità da :tag a :newTag',
        'title'         => 'Sposta :name',
        'transfer'      => 'Sposta',
    ],
];
