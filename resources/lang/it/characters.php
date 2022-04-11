<?php

return [
    'actions'       => [
        'add_appearance'    => 'Aggiungi un dettaglio dell\'aspetto fisico',
        'add_organisation'  => 'Aggiungi un\'organizzazione',
        'add_personality'   => 'Aggiungi un tratto della personalità',
    ],
    'conversations' => [
        'title' => 'Conversazioni del Personaggio :name',
    ],
    'create'        => [
        'success'   => 'Personaggio \':name\' creato.',
        'title'     => 'Nuovo Personaggio',
    ],
    'destroy'       => [
        'success'   => 'Personaggio \':name\' rimosso.',
    ],
    'dice_rolls'    => [
        'hint'  => 'I tiri di dado possono essere assegnati ad un personaggio per essere utilizzati durante la partita.',
        'title' => 'Tiri di dado del Personaggio :name',
    ],
    'edit'          => [
        'success'   => 'Personaggio \':name\' aggiornato.',
        'title'     => 'Modifica del Personaggio :name',
    ],
    'fields'        => [
        'age'                       => 'Età',
        'families'                  => 'Famiglie',
        'family'                    => 'Famiglia',
        'image'                     => 'Immagine',
        'is_appearance_pinned'      => 'Aspetto fissato',
        'is_dead'                   => 'Morto',
        'is_personality_pinned'     => 'Personalità fissata',
        'is_personality_visible'    => 'Personalità visibile',
        'life'                      => 'Vita',
        'location'                  => 'Posizione',
        'name'                      => 'Nome',
        'physical'                  => 'Caratteristiche fisiche',
        'pronouns'                  => 'Pronomi',
        'race'                      => 'Razza',
        'races'                     => 'Razze',
        'relation'                  => 'Relazione',
        'sex'                       => 'Sesso',
        'title'                     => 'Titolo',
        'traits'                    => 'Tratti',
        'type'                      => 'Tipologia',
    ],
    'helpers'       => [
        'age'   => 'Puoi collegare questa entità con un calendario della tua campagna per calcolare automaticamente l\'età.',
    ],
    'hints'         => [
        'is_dead'                   => 'Questo personaggio è morto',
        'is_personality_visible'    => 'Puoi nascondere l\'intera sezione inerente la personalità per le utenze non "Admin".',
        'personality_not_visible'   => 'Solo gli amministratori possono vedere i tratti caratteriali di questo personaggio.',
        'personality_visible'       => 'Tutti possono vedere i tratti carattieriali di questo personaggio.',
    ],
    'index'         => [
        'actions'   => [
            'random'    => 'Nuovo Personaggio Casuale',
        ],
        'add'       => 'Nuovo Personaggio',
        'header'    => 'Personaggi che si trovano a \':name\'',
        'title'     => 'Personaggi',
    ],
    'items'         => [
        'hint'  => 'Gli oggetti possono essere assegnati ai personaggi e risulteranno essere visibili nei loro dettagli.',
        'title' => 'Oggetti del Personaggio :name',
    ],
    'journals'      => [
        'title' => 'Pagine del Diario del Personaggio :name.',
    ],
    'maps'          => [
        'title' => 'Mappa delle Relazioni del Personaggio :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Aggiungi organizzazione',
        ],
        'create'        => [
            'success'   => 'Personaggio aggiunto all\'organizzazione.',
            'title'     => 'Nuova organizzazione per :name',
        ],
        'destroy'       => [
            'success'   => 'Organizzazione del personaggio rimossa.',
        ],
        'edit'          => [
            'success'   => 'Organizzazione del personaggio aggiornata.',
            'title'     => 'Organizzazione aggiornata per :name',
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
        'pronouns'          => 'He/Him, She/Her, They/The,',
        'race'              => 'Razza',
        'races'             => 'Scegli razze',
        'sex'               => 'Sesso',
        'title'             => 'Titolo',
        'traits'            => 'Tratti',
        'type'              => 'NPC, Personaggio Giocante, Divinità',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Missioni per cui il personaggio è il committente.',
            'quest_member'  => 'Missioni di cui il personaggio fa parte.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Aspetto',
        'general'       => 'Informazioni generali',
        'personality'   => 'Personalità',
    ],
    'show'          => [
        'tabs'  => [
            'map'           => 'Mappa delle relazioni',
            'organisations' => 'Organizzazioni',
        ],
        'title' => 'Personaggio :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Non ti è consentito modificare i tratti della personalità di questo personaggio.',
    ],
];
