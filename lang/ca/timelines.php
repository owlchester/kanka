<?php

return [
    'actions'       => [
        'add_element'   => 'Afegeix un element a l\'era :era',
        'back'          => 'Torna a :name',
        'edit'          => 'Edita la línia de temps',
        'save_order'    => 'Guarda l\'ordre nou',
    ],
    'create'        => [
        'title' => 'Nova línia de temps',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_elements' => 'Copia\'n els elements',
        'copy_eras'     => 'Copia\'n les eres',
        'eras'          => 'Eres',
        'reverse_order' => 'Era en ordre invers',
        'timeline'      => 'Línia de temps pare',
        'timelines'     => 'Línies de temps',
    ],
    'helpers'       => [
        'nested_without'    => 'S\'estan mostrant les línies de temps sense pare. Feu clic a la fila d\'un mapa per a mostrar-ne les descendents.',
        'reverse_order'     => 'Habiliteu-ho per a mostrar les eres en ordre cronològic invers (l\'era més antiga primer)',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nom de la línia de temps',
        'type'  => 'Primària, crònica del món, llegat del regne...',
    ],
    'show'          => [
        'tabs'  => [
            'timelines' => 'Línies de temps',
        ],
    ],
    'timelines'     => [
        'title' => 'Línies de temps de :name',
    ],
];
