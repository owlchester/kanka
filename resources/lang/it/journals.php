<?php

return [
    'create'        => [
        'description'   => 'Crea un nuovo diario',
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
        'description'   => 'Gestisci i diari di :name.',
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
        'description'   => 'Una vista dettagliata di un diario',
        'title'         => 'Diario :name',
    ],
];
