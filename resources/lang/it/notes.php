<?php

return [
    'create'        => [
        'success'       => 'Nota \':name\' creata.',
        'title'         => 'Nuova Nota',
    ],
    'destroy'       => [
        'success'   => 'Nota \':name\' rimossa.',
    ],
    'edit'          => [
        'success'   => 'Nota \':name\' aggiornata.',
        'title'     => 'Modifica la Nota :name',
    ],
    'fields'        => [
        'description'   => 'Descrizione',
        'image'         => 'Immagine',
        'is_pinned'     => 'Fissata',
        'name'          => 'Nome',
        'type'          => 'Tipo',
    ],
    'hints'         => [
        'is_pinned' => 'Fino a 3 note possono essere fissate per essere visualizzate nella dashboard.',
    ],
    'index'         => [
        'add'           => 'Nuova Nota',
        'header'        => 'Note di :name',
        'title'         => 'Note',
    ],
    'placeholders'  => [
        'name'  => 'Nome della nota',
        'type'  => 'Religione, Razza, Systema Politico',
    ],
    'show'          => [
        'title'         => 'Nota :name',
    ],
];
