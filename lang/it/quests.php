<?php

return [
    'create'        => [
        'title' => 'Nuova Missione',
    ],
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
    ],
    'fields'        => [
        'copy_elements' => 'Copia gli elementi collegati alla missione',
        'date'          => 'Data',
        'element_role'  => 'Ruolo',
        'instigator'    => 'Iniziatore',
        'is_completed'  => 'Completato',
        'role'          => 'Ruolo',
    ],
    'helpers'       => [
        'is_completed'  => 'Seleziona se la missione è considerata completata.',
    ],
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'date'      => 'Data del mondo reale per la missione',
        'entity'    => 'Nome di un elemento dalla missione',
        'role'      => 'Il ruolo di questa entità nella missione',
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
