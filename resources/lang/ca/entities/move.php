<?php

return [
    'actions'       => [
        'copy'  => 'Copia',
        'move'  => 'Mou',
    ],
    'errors'        => [
        'permission'        => 'No teniu permís per a crear entitats d\'aquest tipus en aquesta campanya.',
        'permission_update' => 'No teniu permís per a moure aquesta entitat.',
        'same_campaign'     => 'Cal que seleccioneu la campanya de destí per a l\'entitat.',
        'unknown_campaign'  => 'Campanya desconeguda.',
    ],
    'fields'        => [
        'campaign'      => 'Campanya de destí',
        'copy'          => 'Crea una còpia a la campanya de destí',
        'select_one'    => 'Trieu una campanya',
    ],
    'panel'         => [
        'description'           => 'Seleccioneu una campanya per a moure-hi o fer-hi una còpia d\'aquesta entitat.',
        'description_bulk_copy' => 'Seleccioneu una campanya a on voleu copiar-hi les entitats seleccionades.',
        'title'                 => 'Moure o copiar una entitat a una altra campanya',
    ],
    'success'       => 'S\'ha mogut l\'entitat :name.',
    'success_copy'  => 'S\'ha copiat l\'entitat :name.',
    'title'         => 'Moure :name',
];
