<?php

return [
    'create'        => [
        'description'   => 'Crea una nuova famiglia',
        'success'       => 'Famiglia \':name\' creata.',
        'title'         => 'Nuova Famiglia',
    ],
    'destroy'       => [
        'success'   => 'Famiglia \':name\' rimossa.',
    ],
    'edit'          => [
        'success'   => 'Famiglia \':name\' aggiornata.',
        'title'     => 'Modifica Famiglia :name',
    ],
    'fields'        => [
        'image'     => 'Immagine',
        'location'  => 'Luogo',
        'members'   => 'Membri',
        'name'      => 'Nome',
        'relation'  => 'Relazione',
    ],
    'hints'         => [
        'members'   => 'I membri di una famiglia sono mostrati qui. Un personaggio può essere aggiunto alla famiglia modificando il personaggio, usando il selettore "Famiglia".',
    ],
    'index'         => [
        'add'           => 'Nuova Famiglia',
        'description'   => 'Gestisci le famiglie di :name',
        'header'        => 'Famiglie di :name',
        'title'         => 'Famiglie',
    ],
    'placeholders'  => [
        'location'  => 'Scegli un luogo',
        'name'      => 'Nome della famiglia',
    ],
    'show'          => [
        'description'   => 'Una vista dettagliata della famiglia',
        'tabs'          => [
            'member'    => 'Membri',
            'relation'  => 'Relazioni',
        ],
        'title'         => 'Famiglia :name',
    ],
];
