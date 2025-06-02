<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Aggiungi un nuovo tag',
            'add_entity'    => 'Aggiungi all\'entità',
        ],
        'create'    => [
            'attach_success'        => '{1} Aggiunto :count entità al tag :name.|[2,*] Aggiunte :count entità al tag :name.',
            'attach_success_entity' => 'Tag aggiornati con successo per :name.',
            'entity'                => 'Aggiungi tag a :name',
        ],
    ],
    'create'        => [
        'title' => 'Nuovo Tag',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Discendenti',
        'is_auto_applied'   => 'Applica automaticamente alle nuove entità',
        'is_hidden'         => 'Nascosto dall\'intestazione e dal tooltip',
    ],
    'helpers'       => [
        'no_children'   => 'Al momento non ci sono entità con questo tag.',
    ],
    'hints'         => [
        'children'          => 'Questo elenco contiene tutte le entità assegnate a questo tag o ai suoi discendenti.',
        'is_auto_applied'   => 'Seleziona questa opzione per applicare automaticamente questo tag alle entità appena create.',
        'is_hidden'         => 'Se selezionato, questo tag non sarà visualizzato nell\'intestazione o nel tooltip di un\'entità.',
        'tag'               => 'Questo elenco contiene tutti i tag discendenti di questo tag o dei suoi tag discendenti.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Tradizioni, Guerre, Storia, Religione, Araldica',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Discendente',
        ],
    ],
    'tags'          => [],
    'transfer'      => [
        'fail'      => 'Impossibile trasferire le entità da :tag a :newTag',
        'success'   => 'Spostate con successo le entità da :tag a :newTag',
        'transfer'  => 'Sposta',
    ],
];
