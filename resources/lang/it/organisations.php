<?php

return [
    'create'        => [
        'description'   => 'Crea una nuova organizzazione',
        'success'       => 'Organizzazione \':name\' creata.',
        'title'         => 'Nuova Organizzazione',
    ],
    'destroy'       => [
        'success'   => 'Organizzazione \':name\' rimossa.',
    ],
    'edit'          => [
        'success'   => 'Organizzazione \':name\' aggiornata.',
        'title'     => 'Modifica l\'organizzazione :name',
    ],
    'fields'        => [
        'image'         => 'Immagine',
        'location'      => 'Luogo',
        'members'       => 'Membri',
        'name'          => 'Nome',
        'organisation'  => 'Organizzazione Padre',
        'organisations' => 'Sotto-Organizzazioni',
        'relation'      => 'Relazione',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Questa lista contiene tutte le organizzazione che sono discendenti di questa organizzazione, non solo quelle direttamente sotto di essa.',
        'nested'        => 'Quando ci si trova nella vista annidata puoi vedere le tue Organizzazioni in maniera annidata. Organizzazioni senza genitori saranno mostrate in maniera predefinita. Organizzazioni con discendenti potranno essere premute per vederne i figli. Potrai continuare ad espandere le organizzazioni fino a quando non ci saranno più figli da mostrare.',
    ],
    'index'         => [
        'add'           => 'Nuova Organizzazione',
        'description'   => 'Gestisci le organizzazioni di :name.',
        'header'        => 'Organizzazioni di :name',
        'title'         => 'Organizzazioni',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Aggiungi un membro',
        ],
        'create'        => [
            'description'   => 'Aggiungi un membro all\'organizzazione',
            'success'       => 'Membro aggiunto all\'organizzazione',
            'title'         => 'Nuovo Membro dell\'Organizzazione :name',
        ],
        'destroy'       => [
            'success'   => 'Membro rimosso dall\'organizzazione',
        ],
        'edit'          => [
            'success'   => 'Mebro dell\'organizzazione aggiornato.',
            'title'     => 'Aggiorna Membro per :name',
        ],
        'fields'        => [
            'character'     => 'Personaggio',
            'organisation'  => 'Organizzazione',
            'role'          => 'Ruolo',
        ],
        'helpers'       => [
            'members'   => 'La lista seguente rappresenta tutti i personaggi che fanno parte di questa organizzazione e di tutte le organizzazioni che ne discendono.',
        ],
        'placeholders'  => [
            'character' => 'Seleziona un personaggio',
            'role'      => 'Leader, Membro, Alto Septon, Maestro di Spinaggio',
        ],
        'title'         => 'Membri dell\'Organizzazione :name',
    ],
    'organisations' => [
        'title' => 'Organizzazioni dell\'Organizzazione :name',
    ],
    'placeholders'  => [
        'location'  => 'Seleziona un luogo',
        'name'      => 'Nome dell\'organizzazione',
        'type'      => 'Culto, Banda, Ribellione, Fandom',
    ],
    'quests'        => [
        'description'   => 'Missioni delle quali fa parte l\'organizzazione.',
        'title'         => 'Missioni dell\'organizzazione :name',
    ],
    'show'          => [
        'description'   => 'Una vista dettagliata di un\'organizzazione',
        'tabs'          => [
            'organisations' => 'Organizzazioni',
            'quests'        => 'Missioni',
            'relations'     => 'Relazioni',
        ],
        'title'         => 'Organizzazione :name',
    ],
];
