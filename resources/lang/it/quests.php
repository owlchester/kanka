<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Associa un personaggio ad una Missione',
            'success'       => 'Personaggio aggiunto alla missione :name.',
            'title'         => 'Nuovo personaggio per :name',
        ],
        'destroy'   => [
            'success'   => 'Personaggio rimosso dalla missione :name.',
        ],
        'edit'      => [
            'description'   => 'Aggiorna un personaggio della missione',
            'success'       => 'Personaggio aggiornato nella missione :name.',
            'title'         => 'Aggiorna personaggio per :name',
        ],
        'fields'    => [
            'character'     => 'Personaggio',
            'description'   => 'Descrizione',
        ],
        'title'     => 'Personaggi per :name',
    ],
    'create'        => [
        'description'   => 'Crea una nuova missione',
        'success'       => 'Missione \':name\' creata.',
        'title'         => 'Nuova Missione',
    ],
    'destroy'       => [
        'success'   => 'Missione \':name\' rimossa.',
    ],
    'edit'          => [
        'description'   => 'Modifica una missione',
        'success'       => 'Missione \':name\' aggiornata.',
        'title'         => 'Modifica la missione :name',
    ],
    'fields'        => [
        'character'     => 'Istigatore',
        'characters'    => 'Personaggi',
        'date'          => 'Data',
        'description'   => 'Descrizione',
        'image'         => 'Immagine',
        'is_completed'  => 'Completata',
        'items'         => 'Oggetti',
        'locations'     => 'Luoghi',
        'name'          => 'Nome',
        'organisations' => 'Organizzazioni',
        'quest'         => 'Missione Padre',
        'quests'        => 'Sotto-Missioni',
        'role'          => 'Ruolo',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Quando ci si trova nella vista annidata puoi vedere le tue Missioni in maniera annidata. Missioni senza genitori saranno mostrate in maniera predefinita. Missioni con discendenti potranno essere premute per vederne i figli. Potrai continuare ad espandere le missioni fino a quando non ci saranno più figli da mostrare.',
    ],
    'hints'         => [
        'quests'    => 'Una ragnatela di missioni interconnesse può essere costruita utilizzando il campo "Missione Padre".',
    ],
    'index'         => [
        'add'           => 'Nuova Missione',
        'description'   => 'Gestisci le missioni per :name',
        'header'        => 'Missioni di :name',
        'title'         => 'Missioni',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Associa un oggetto ad una missione',
            'success'       => 'Oggetto aggiunto a :name',
            'title'         => 'Nuovo oggetto per :name',
        ],
        'destroy'   => [
            'success'   => 'Oggetto della missione per :name rimosso.',
        ],
        'edit'      => [
            'description'   => 'Aggiorna un oggetto della missione',
            'success'       => 'Oggetto della missione per :name aggiornato.',
            'title'         => 'Aggiorna un oggetto per :name',
        ],
        'fields'    => [
            'description'   => 'Descrizione',
            'item'          => 'Oggetto',
        ],
        'title'     => 'Oggetti per :name',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Imposta un luogo ad una missione',
            'success'       => 'Luogo aggiunto per :name',
            'title'         => 'Nuovo Luogo per :name',
        ],
        'destroy'   => [
            'success'   => 'Luogo della missione rimosso per :name',
        ],
        'edit'      => [
            'description'   => 'Aggiorna un luogo della missione',
            'success'       => 'Luogo della missione aggiornati per :name',
            'title'         => 'Aggiorna il luogo per :name',
        ],
        'fields'    => [
            'description'   => 'Descrizione',
            'location'      => 'Luogo',
        ],
        'title'     => 'Luoghi per :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Associa un\'organizzazione ad una missione',
            'success'       => 'Organizzazione aggiunta a :name',
            'title'         => 'Nuova Organizzazione per :name',
        ],
        'destroy'   => [
            'success'   => 'Organizzazione della missione per :name rimossa.',
        ],
        'edit'      => [
            'description'   => 'Aggiorna un\'organizzazione di una quest',
            'success'       => 'Organizzazione della missione per :name aggiornata.',
            'title'         => 'Aggiorna un\'organizzazione per :name',
        ],
        'fields'    => [
            'description'   => 'Descrizione',
            'organisation'  => 'Organizzazione',
        ],
        'title'     => 'Organizzazioni per :name',
    ],
    'placeholders'  => [
        'date'  => 'Data del mondo reale per la missione',
        'name'  => 'Nome della missione',
        'quest' => 'Missione Padre',
        'role'  => 'Il ruolo dell\'entità nella missione',
        'type'  => 'Personaggio, Missione Secondaria, Missione Principale',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Aggiungi un personaggio',
            'add_item'          => 'Aggiungi un\'oggetto',
            'add_location'      => 'Aggiungi un luogo',
            'add_organisation'  => 'Aggiungi un\'organizzazione',
        ],
        'description'   => 'Una visualizzazione dettagliata di una missione',
        'tabs'          => [
            'characters'    => 'Personaggi',
            'information'   => 'Informazioni',
            'items'         => 'Oggetti',
            'locations'     => 'Luoghi',
            'organisations' => 'Organizzazioni',
            'quests'        => 'Missioni',
        ],
        'title'         => 'Missione :name',
    ],
];
