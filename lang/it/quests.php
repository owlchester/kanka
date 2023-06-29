<?php

return [
    'create'        => [],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Elemento :entity aggiunto alla missione.',
            'title'     => 'Nuovo elemento per :name',
        ],
        'destroy'   => [
            'success'   => 'Elemento :entity rimosso.',
        ],
        'edit'      => [
            'success'   => 'Elemento :entity aggiornato.',
            'title'     => 'Modifica elemento per :name',
        ],
        'fields'    => [
            'description'       => 'Descrizione',
            'entity_or_name'    => 'Seleziona un\'entità della campagna o dai un nome a questo elemento.',
            'name'              => 'Nome',
        ],
        'warning'   => [
            'editing'   => [
                'description'   => 'Sembra che qualcun altro stia modificando questo elemento della missione! Vuoi tornare indietro o ignorare questo avviso, con il rischio di perdere i dati? Membri che stanno modificando questo elemento della missione:',
            ],
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Copia gli elementi collegati alla missione',
        'element_role'  => 'Ruolo',
        'instigator'    => 'Iniziatore',
    ],
    'helpers'       => [
        'is_completed'      => 'Seleziona se la missione è considerata completata.',
        'nested_without'    => 'Visualizzazione di tutte le missioni che non hanno una missione genitore. Fai clic su una riga per vedere le missioni figlio.',
    ],
    'hints'         => [
        'quests'    => 'Una ragnatela di missioni interconnesse può essere costruita utilizzando il campo "Missione Genitore".',
    ],
    'index'         => [],
    'placeholders'  => [
        'entity'    => 'Nome di un elemento dalla missione',
        'type'      => 'Arco Narrativo, Missione Secondaria, Missione Principale',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Aggiungi un elemento',
        ],
        'tabs'      => [
            'elements'  => 'Elementi',
        ],
    ],
];
