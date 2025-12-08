<?php

return [
    'actions'   => [],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Tipo di entità sconosciuto o non valido.',
        ],
        'success'   => '{1} :count entità trasformata a nuovo tipo :type.|[2,*] :count entità trasformate al nuovo tipo: :type.',
    ],
    'fields'    => [
        'select_one'    => 'Seleziona uno',
        'target'        => 'Nuovo tipo di entità',
    ],
    'panel'     => [
        'bulk_description'  => 'Cambia il tipo di entità in molteplici entità. Tieni presente che alcuni dati potrebbero andare persi a causa dei diversi campi tra i tipi di entità.',
        'bulk_title'        => 'Trasforma le entità in blocco',
        'title'             => 'Trasforma un entità',
    ],
    'success'   => 'Entità :name trasformata.',
    'title'     => 'Trasforma :name',
];
