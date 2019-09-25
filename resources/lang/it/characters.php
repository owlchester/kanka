<?php

return [
    'actions'       => [
        'add_appearance'    => 'Aggiungi un dettaglio dell\'aspetto fisico',
        'add_organisation'  => 'Aggiungi un\'organizzazione',
        'add_personality'   => 'Aggiungi un tratto della personalità',
    ],
    'conversations' => [
        'description'   => 'Conversazioni in cui il personaggio sta partecipando.',
        'title'         => 'Conversazioni del Personaggio :name',
    ],
    'create'        => [
        'description'   => 'Crea un nuovo personaggio',
        'success'       => 'Personaggio \':name\' creato.',
        'title'         => 'Nuovo Personaggio',
    ],
    'destroy'       => [
        'success'   => 'Personaggio \':name\' rimosso.',
    ],
    'dice_rolls'    => [
        'description'   => 'Tiri di dado assegnati al personaggio.',
        'hint'          => 'I tiri di dado possono essere assegnati ad un personaggio per essere utilizzati durante la partita.',
        'title'         => 'Tiri di dado del Personaggio :name',
    ],
    'edit'          => [
        'description'   => 'Modifica un personaggio',
        'success'       => 'Personaggio \':name\' aggiornato.',
        'title'         => 'Modifica del Personaggio :name',
    ],
    'fields'        => [
        'age'                       => 'Età',
        'family'                    => 'Famiglia',
        'image'                     => 'Immagine',
        'is_dead'                   => 'Morto',
        'is_personality_visible'    => 'Personalità visibile',
        'location'                  => 'Posizione',
        'name'                      => 'Nome',
        'physical'                  => 'Caratteristiche fisiche',
        'race'                      => 'Razza',
        'relation'                  => 'Relazione',
        'sex'                       => 'Sesso',
        'title'                     => 'Titolo',
        'traits'                    => 'Tratti',
        'type'                      => 'Tipologia',
    ],
    'helpers'       => [
        'free'  => 'Dov\'è finito il campo "Libero"? Se questo personaggio ne aveva uno è stato mosso in alto all\'interno della nuova tab "Note"!',
    ],
    'hints'         => [
        'hide_personality'          => 'Questa tab può essere invisibile alle utenze non "Admin" disabilitando l\'opzione "Personalità Visibile" quando si modifica questo personaggio.',
        'is_dead'                   => 'Questo personaggio è morto',
        'is_personality_visible'    => 'Puoi nascondere l\'intera sezione inerente la personalità per le utenze non "Admin".',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Nuovo Personaggio Casuale',
        ],
        'add'           => 'Nuovo Personaggio',
        'description'   => 'Gestisci i personaggi di :name.',
        'header'        => 'Personaggi che si trovano a \':name\'',
        'title'         => 'Personaggi',
    ],
    'items'         => [
        'description'   => 'Oggetti impugnati o posseduti dal personaggio.',
        'hint'          => 'Gli oggetti possono essere assegnati ai personaggi e risulteranno essere visibili nei loro dettagli.',
        'title'         => 'Oggetti del Personaggio :name',
    ],
    'journals'      => [
        'description'   => 'Pagine del diario di cui il personaggio è autore.',
        'title'         => 'Pagine del Diario del Personaggio :name.',
    ],
    'maps'          => [
        'description'   => 'Mappa delle relazioni del personaggio.',
        'title'         => 'Mappa delle Relazioni del Personaggio :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Aggiungi organizzazione',
        ],
        'create'        => [
            'description'   => 'Associa un\'organizzazione ad un personaggio',
            'success'       => 'Personaggio aggiunto all\'organizzazione.',
            'title'         => 'Nuova organizzazione per :name',
        ],
        'description'   => 'Organizzazioni dei cui il personaggio fa parte.',
        'destroy'       => [
            'success'   => 'Organizzazione del personaggio rimossa.',
        ],
        'edit'          => [
            'description'   => 'Aggiorna l\'organizzazione del personaggio',
            'success'       => 'Organizzazione del personaggio aggiornata.',
            'title'         => 'Organizzazione aggiornata per :name',
        ],
        'fields'        => [
            'organisation'  => 'Organizzazione',
            'role'          => 'Ruolo',
        ],
        'hint'          => 'I personaggio possono fare parte di più organizzazioni rappresentando per chi lavorano o di quale società segreta fanno parte.',
        'placeholders'  => [
            'organisation'  => 'Seleziona un\'organizzazione...',
        ],
        'title'         => 'Organizzazioni del Personaggio :name',
    ],
    'placeholders'  => [
        'age'               => 'Età',
        'appearance_entry'  => 'Descrizione',
        'appearance_name'   => 'Capelli, Occhi, Pelle, Altezza',
        'family'            => 'Per favore seleziona un personaggio',
        'image'             => 'Immagine',
        'location'          => 'Per favore seleziona un luogo',
        'name'              => 'Nome',
        'personality_entry' => 'Dettagli',
        'personality_name'  => 'Obbiettivi, Vezzi, Paure, Vincoli',
        'physical'          => 'Caratteristiche Fisiche',
        'race'              => 'Razza',
        'sex'               => 'Sesso',
        'title'             => 'Titolo',
        'traits'            => 'Tratti',
        'type'              => 'NPC, Personaggio Giocante, Divinità',
    ],
    'quests'        => [
        'description'   => 'Missioni intraprese da un personaggio',
        'helpers'       => [
            'quest_giver'   => 'Missioni per cui il personaggio è il committente.',
            'quest_member'  => 'Missioni di cui il personaggio fa parte.',
        ],
        'title'         => 'Missioni del Personaggio :name',
    ],
    'sections'      => [
        'appearance'    => 'Aspetto',
        'general'       => 'Informazioni generali',
        'personality'   => 'Personalità',
    ],
    'show'          => [
        'description'   => 'Una vista dettaglia di un personaggio',
        'tabs'          => [
            'conversations' => 'Conversazioni',
            'dice_rolls'    => 'Tiri di dado',
            'items'         => 'Oggetti',
            'journals'      => 'Pagine del diario',
            'map'           => 'Mappa delle relazioni',
            'organisations' => 'Organizzazioni',
            'personality'   => 'Personalità',
            'quests'        => 'Missioni',
        ],
        'title'         => 'Personaggio :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Non ti è consentito modificare i tratti della personalità di questo personaggio.',
    ],
];
