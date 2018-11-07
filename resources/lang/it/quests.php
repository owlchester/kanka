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
        'description'   => 'Descrizione',
        'image'         => 'Immagine',
        'is_completed'  => 'Completata',
        'locations'     => 'Luoghi',
        'name'          => 'Nome',
        'quest'         => 'Missione Padre',
        'type'          => 'Tipo',
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
    ],
    'placeholders'  => [
        'name'  => 'Nome della missione',
        'quest' => 'Missione Padre',
        'type'  => 'Personaggio, Missione Secondaria, Missione Principale',
    ],
    'show'          => [
        'actions'       => [
            'add_character' => 'Aggiungi un personaggio',
            'add_location'  => 'Aggiungi un luogo',
        ],
        'description'   => 'Una visualizzazione dettagliata di una missione',
        'tabs'          => [
            'characters'    => 'Personaggi',
            'information'   => 'Informazioni',
            'locations'     => 'Luoghi',
            'quests'        => 'Missioni',
        ],
        'title'         => 'Missione :name',
    ],
];
