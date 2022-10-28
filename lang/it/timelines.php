<?php

return [
    'actions'       => [
        'add_element'   => 'Aggiungi all\'era :era',
        'back'          => 'Torna a :nome',
        'edit'          => 'Modifica linea temporale',
        'save_order'    => 'Salva nuovo ordine',
    ],
    'create'        => [
        'title' => 'Nuova linea temporale',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_elements' => 'Copia elementi',
        'copy_eras'     => 'Copia ere',
        'eras'          => 'Ere',
        'reverse_order' => 'Inverti l\'ordine delle ere',
        'timeline'      => 'Linea temporale principale',
        'timelines'     => 'Linee temporali',
    ],
    'helpers'       => [
        'nested_without'    => 'Tutte le linee temporali che non hanno una linea temporale principale. Clicca su una riga per vedere le linee temporali figlie',
        'no_era'            => 'Attualmente questa linea temporale non ha ere. Le ere possono essere aggiunte nella schermata di modifica delle linee temporali, dove è possibile aggiungere elementi.',
        'reverse_order'     => 'Abilita per visualizzare le ere in ordine cronologico inverso (prima l\'era più antica)',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nome della linea temporale',
        'type'  => 'Principale, Cronache del mondo, Storia del Regno',
    ],
    'show'          => [
        'tabs'  => [
            'timelines' => 'Linee temporali',
        ],
    ],
    'timelines'     => [
        'title' => 'Linea temporale :name Linee temporali',
    ],
];
