<?php

return [
    'actions'   => [
        'gallery'   => 'Dalla galleria',
        'url'       => 'Carica un\'immagine da un URL',
    ],
    'browse'    => [
        'layouts'       => [
            'large' => 'Anteprime grandi',
            'small' => 'Anteprime piccole',
        ],
        'search'        => [
            'placeholder'   => 'Cerca un\'immagine nella galleria',
        ],
        'title'         => 'Galleria',
        'unauthorized'  => 'Nessuno dei tuoi ruoli ha l\'autorizzazione per sfogliare la galleria.',
    ],
    'delete'    => [
        'success'   => '[0] Eliminati 0 elementi|[1] Eliminato un elemento|{2,*} Eliminati :count elementi',
    ],
    'download'  => [
        'errors'    => [
            'copy_failed'           => 'I nostri server non sono riusciti a scaricare l\'immagine indicata.',
            'gallery_full_free'     => 'Lo spazio di archiviazione della galleria è esaurito. Attiva le funzioni premium per avere più spazio di archiviazione.',
            'gallery_full_premium'  => 'Lo spazio di archiviazione della galleria è pieno. Rimuovi prima i file inutilizzati.',
            'invalid_format'        => 'Il file non è di formato valido.',
            'too_big'               => 'Il file è troppo grande.',
            'unauthorized'          => 'Nessuno dei tuoi ruoli ha l\'autorizzazione per caricare nella galleria.',
        ],
    ],
    'file'      => [
        'saved' => 'Salvato',
    ],
    'filters'   => [
        'only_unused'   => 'Mostra solo i file non utilizzati',
    ],
    'move'      => [
        'success'   => '[0] Mossi 0 elementi|[1] Mosso un elemento|{2,*} Mossi :count elementi',
    ],
    'update'    => [
        'home'      => 'Cartella Principale',
        'success'   => '[0] Aggiornati 0 elementi|[1] Aggiornato un elemento|{2,*} Aggiornati :count elementi',
    ],
];
