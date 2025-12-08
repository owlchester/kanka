<?php

return [
    'actions'       => [
        'copy'  => 'Copia',
    ],
    'errors'        => [
        'permission'        => 'Non puoi creare entità di questo tipo nella campagna di destinazione.',
        'permission_update' => 'Non puoi muovere questa entità.',
        'same_campaign'     => 'Devi selezionare un\'altra campagna per muoverci l\'entità.',
        'unknown_campaign'  => 'Campagna sconosciuta.',
    ],
    'fields'        => [
        'campaign'      => 'Campagna di destinazione',
        'copy'          => 'Crea una copia',
        'select_one'    => 'Seleziona una campagna',
    ],
    'helpers'       => [
        'copy'  => 'Crea una copia dell\'entità nella campagna di destinazione.',
    ],
    'panel'         => [
        'description'           => 'Muovi questa entità a un\'altra campagna, o crea una copia di questa in un\'altra campagna.',
        'description_bulk_copy' => 'Seleziona una campagna in cui vuoi copiare le entità selezionate.',
        'title'                 => 'Muovi o copia un\'entità a un\'altra campagna',
    ],
    'success'       => 'Entità :name mossa alla campagna :campaign.',
    'success_copy'  => 'Entità :name copiata alla campagna :campaign.',
    'title'         => 'Muovi :name',
];
