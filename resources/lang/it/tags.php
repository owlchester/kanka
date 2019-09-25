<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Aggiungi un nuovo tag',
        ],
        'create'        => [
            'title' => 'Aggiungi un tag a :name',
        ],
        'description'   => 'Entità associate al tag',
        'title'         => 'Discendente del tag :name',
    ],
    'create'        => [
        'description'   => 'Crea un nuovo tag',
        'success'       => 'Tag \':name\' creato.',
        'title'         => 'Nuovo Tag',
    ],
    'destroy'       => [
        'success'   => 'Tag \':name\' rimosso.',
    ],
    'edit'          => [
        'success'   => 'Tag \':name\' aggiornato.',
        'title'     => 'Modifica il Tag :name',
    ],
    'fields'        => [
        'characters'    => 'Personaggi',
        'children'      => 'Figli',
        'name'          => 'Nome',
        'tag'           => 'Tag',
        'tags'          => 'Sotto-Tag',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Quando sei nella Visualizzazione Annidata, puoi vedere i tuoi tag in modalità nidificata. I tag senza un genitore verranno mostrati come standards. I tag con dei figli potranno essere premuti per mostrarne i figli. Puoi continuare a premere finché non ci saranno più figli da mostrare.',
    ],
    'hints'         => [
        'children'  => 'Questa lista contiene tutte le entità direttamente assegnate a questo tag ed in tuuìtti i tad discendenti.',
        'tag'       => 'Visualizzati sotto vi sono tutti i tag che sono direttamente sotto a questo.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Visualizzazione annidata',
        ],
        'add'           => 'Nuovo tag',
        'description'   => 'Gestisci i tag per :name',
        'header'        => 'Tags per :name',
        'title'         => 'Tags',
    ],
    'new_tag'       => 'Nuovo Tag',
    'placeholders'  => [
        'name'  => 'Nome del tag',
        'tag'   => 'Seleziona un tag genitore',
        'type'  => 'Tradizioni, Guerre, Storia, Religione, Araldica',
    ],
    'show'          => [
        'description'   => 'Una vista dettagliata di un tag',
        'tabs'          => [
            'children'      => 'Figlio',
            'information'   => 'Informazioni',
            'tags'          => 'Tags',
        ],
        'title'         => 'Tag :name',
    ],
    'tags'          => [
        'description'   => 'Tag Discendenti',
        'title'         => 'Discendente del tag :name',
    ],
];
