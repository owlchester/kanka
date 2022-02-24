<?php

return [
    'create'        => [
        'success'       => 'Diario \':name\' creato.',
        'title'         => 'Nuovo Diario',
    ],
    'destroy'       => [
        'success'   => 'Diario \':name\' rimosso.',
    ],
    'edit'          => [
        'success'   => 'Diario \':name\' aggiornato.',
        'title'     => 'Modifica del diario :name',
    ],
    'fields'        => [
        'author'    => 'Autore',
        'date'      => 'Data',
        'image'     => 'Immagine',
        'name'      => 'Nome',
        'relation'  => 'Relazione',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nuovo Diario',
        'header'        => 'Diari di :name',
        'title'         => 'Diari',
    ],
    'placeholders'  => [
        'author'    => 'Chi ha scritto il diario',
        'date'      => 'Data del diario',
        'name'      => 'Nome del diario',
        'type'      => 'Sessione, One Shot, Bozza',
    ],
    'show'          => [
        'title'         => 'Diario :name',
    ],
];
